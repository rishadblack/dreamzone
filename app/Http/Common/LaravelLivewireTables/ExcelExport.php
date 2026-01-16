<?php

namespace App\Http\Common\LaravelLivewireTables;

use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\BeforeExport;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Maatwebsite\Excel\Concerns\WithPreCalculateFormulas;

class ExcelExport implements FromQuery, ShouldQueue, WithStyles, WithEvents, WithPreCalculateFormulas, ShouldAutoSize, WithMapping, WithHeadings
{
    use Exportable;

    /**
     * 8 = A3 paper (297 mm by 420 mm)
     * 9 = A4 paper (210 mm by 297 mm)
     * 10 = A4 small paper (210 mm by 297 mm)
     * 11 = A5 paper (148 mm by 210 mm)
     * 12 = B4 paper (250 mm by 353 mm)
     * 13 = B5 paper (176 mm by 250 mm).
     *
     *  orientation = default / landscape / portrait.
     **/

    public $query;
    public $columns;
    public $headerText = [];
    public $titleText = 'Vessel Report';
    public $paperSize = 9;
    public $orientation = 'default';


    public function getColunmMaps($row): array
    {
        return $this->columns->map(function ($column) use ($row) {
            return $this->columnRender($column, $row);
        })->toArray();
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('This is my logo');
        $drawing->setPath(public_path('storage/photos/G838d1mETGciswtzI9YKDeENndHSZRtGZJIN4xeK.jpg'));
        $drawing->setHeight(100);
        $drawing->setCoordinates('A1');

        return $drawing;
    }

    public function styles(Worksheet $sheet)
    {
        $allRowStyle = [];

        for ($i = 2; $i < $this->query()->count() + 2; ++$i) {
            $allRowStyle[$i] = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['rgb' => '808080'],
                    ],
                ],
            ];
        }

        return $allRowStyle;
    }

    public function sumRows()
    {
        return $this->columns->filter(function ($column) {
            return $column->hasFooter();
        });
    }

    public function columnRender($column, $row)
    {
        if ($column->isHtml()) {
            return strip_tags($column->renderContents($row));
        }

        if ($column->eagerLoadRelationsIsEnabled()) {
            return $column->getContents($row);
        }

        return $column->renderContents($row);
    }

    public function hasColumnExists($column, $fieldName)
    {
        if ($column->hasFrom() && $column->getFrom() == $fieldName) {
            return true;
        } elseif (!$column->hasFrom() && $column->isField($fieldName)) {
            return true;
        }

        return false;
    }

    public function headings(): array
    {
        return $this->columns->map(function ($column) {
            return $column->getTitle();
        })->toArray();
    }

    public function map($row): array
    {
        return $this->getColunmMaps($row);
    }

    public function setTitleText($titleText)
    {
        $this->titleText = $titleText;
        return $this;
    }

    public function setColumns($columns)
    {
        $this->columns = $columns;
        return $this;
    }

    public function setPaperSize($paperSize)
    {
        $this->paperSize = $paperSize;
        return $this;
    }

    public function setOrientation($orientation)
    {
        $this->orientation = $orientation;
        return $this;
    }

    public function setHeaderText($headerText = [])
    {
        $this->headerText = $headerText;
        return $this;
    }

    public function setQuery($query)
    {
        $this->query = $query;
        return $this;
    }

    public function query()
    {
        return $this->query;
    }

    public function registerEvents(): array
    {
        return [
            BeforeExport::class => function (BeforeExport $event) {
                $event->writer->getProperties()->setCreator(config('app.name'));
            },

            AfterSheet::class => function (AfterSheet $event) {
                $columns = collect($this->columns);

                $event->sheet->getPageMargins()->setTop('.25');
                $event->sheet->getPageMargins()->setBottom('.25');
                $event->sheet->getPageMargins()->setLeft('.25');
                $event->sheet->getPageMargins()->setRight('.25');

                // last column as letter value (e.g., D)
                $last_column = Coordinate::stringFromColumnIndex($columns->count());
                $totalRow = 5;
                $totalHeadRow =6;

                if (count($this->headerText) > 0) {
                    foreach ($this->headerText as $key => $value) {
                        ++$totalHeadRow;
                        ++$totalRow;
                    }
                }

                // calculate last row + 1 (total results + header rows + column headings row + new row)
                $last_row = $this->query()->count() + $totalRow;

                // set up a style array for cell formatting
                $style_text_center = [
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'color' => ['rgb' => 'ffffff'],
                    ],
                ];

                // $event->sheet->getStyle()->getFont()->setBold(true);

                $titleStyleText = [
                    'font' => [
                        'bold' => true,
                        'size' => '16',
                        'margin-right'=>'20',
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'color' => ['rgb' => 'ffffff'],
                    ],
                ];
                $titleStyleTextA2 = [
                           'font' => [
                               'bold' => true,
                               'size' => '14',
                           ],
                           'fill' => [
                               'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                               'color' => ['rgb' => 'ffffff'],
                           ],
                       ];
                $titleStyleTextA3 = [
                    'font' => [
                        'bold' => true,
                        'size' => '11',
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'color' => ['rgb' => 'ffffff'],
                    ],
                ];
                $titleStyleTextA4 = [
                    'font' => [
                        'bold' => true,
                        'size' => '11',
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'color' => ['rgb' => 'ffffff'],
                    ],
                ];
                $titleStyleTextA4 = [
                   'font' => [
                       'bold' => true,
                       'size' => '11',
                   ],
                   'fill' => [
                       'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                       'color' => ['rgb' => 'ffffff'],
                   ],
                                ];
                $titleStyleTextA5 = [
                    'font' => [
                        'bold' => true,
                        'size' => '14',
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'color' => ['rgb' => 'ffffff'],
                    ],
                ];

                // $event->sheet->setPageMargin(0);
                $event->sheet->getPageSetup()->setPaperSize($this->paperSize)->setOrientation($this->orientation);
                // at row 1, insert 2 rows
                $event->sheet->insertNewRowBefore(1, $totalHeadRow);
                // dd($totalHeadRow);

                // merge cells for full-width
                $event->sheet->mergeCells(sprintf('A1:%s1', $last_column));
                $event->sheet->mergeCells(sprintf('A2:%s2', $last_column));
                $event->sheet->mergeCells(sprintf('A3:%s3', $last_column));
                $event->sheet->mergeCells(sprintf('A4:%s4', $last_column));

                $drawing = new Drawing();
                $drawing->setName('Logo');
                $drawing->setDescription('This is my logo');
                $drawing->setPath(storage_path('photos/logo.jpg'));
                $drawing->setHeight(40);
                $drawing->setWidth(60);
                $drawing->setCoordinates('A1');
                $drawing->setWorksheet($event->sheet->getDelegate());

                // assign cell values
                $event->sheet->setCellValue('A1', '');
                $event->sheet->getStyle('A1')->applyFromArray($titleStyleText);

                $event->sheet->setCellValue('A2', "Sustainable Coastal and Marine Fisheries Project");
                $event->sheet->getStyle('A2')->applyFromArray($titleStyleTextA2);

                $event->sheet->setCellValue('A3', "Departments: Ministry of Fisheries And livestock, Dhaka, Bangladesh");
                $event->sheet->getStyle('A3')->applyFromArray($titleStyleTextA3);
                $event->sheet->setCellValue('A4', "Motorized Craft and Gear Survey");
                $event->sheet->getStyle('A4')->applyFromArray($titleStyleTextA4);
                $event->sheet->setCellValue('A5', "Vessel Report : 01");
                $event->sheet->getStyle('A1:A5')->applyFromArray($style_text_center);

                if (count($this->headerText) > 0) {
                    $gapKey = 0;
                    foreach ($this->headerText as $key => $value) {
                        $gapKey = $key + 3;
                        $event->sheet->mergeCells(sprintf('A%d:%s%d', $gapKey, $last_column, $gapKey));
                        $event->sheet->setCellValue(sprintf('A%s', $gapKey), $value);
                        $event->sheet->getStyle(sprintf('A%s', $gapKey))->applyFromArray($style_text_center);
                    }

                    $event->sheet->mergeCells(sprintf('A%d:%s%d', ($gapKey + 1), $last_column, ($gapKey + 1)));
                }

                if ($this->sumRows()->count() > 0) {
                    $event->sheet->setCellValue(sprintf('A%d', ($last_row + 1)), 'Total : ');

                    foreach ($this->sumRows() as $key => $value) {
                        $sumColumn = Coordinate::stringFromColumnIndex($key + 1);
                        $event->sheet->setCellValue(sprintf('%s%d', $sumColumn, ($last_row + 1)), '=SUM('.sprintf('%s%d', $sumColumn, ($totalRow + 1)).':'.sprintf('%s%d', $sumColumn, $last_row).')');
                        if ($value->getField() == 'balance') {
                            $event->sheet->setCellValue(sprintf('%s%d', $sumColumn, ($last_row + 1)), '='.sprintf('%s%d', $sumColumn, $last_row));
                        }
                    }
                    $event->sheet->getStyle(sprintf('A%d:%s%d', ($last_row + 1), $last_column, ($last_row + 1)))->applyFromArray([
                        'font' => [
                            'bold' => true,
                        ],
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'color' => ['rgb' => 'C0C0C0'],
                        ],
                    ]);
                }

                $event->sheet->getStyle(sprintf('A%d', $last_row))->applyFromArray($style_text_center);
                $event->sheet->getStyle(sprintf('A%d:%s%d', ($totalHeadRow + 1), $last_column, ($totalHeadRow + 1)))->applyFromArray([
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ],
                    'font' => [
                        'bold' => true,
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'color' => ['rgb' => 'C0C0C0'],
                    ],
                ]);
            },
        ];
    }
}
