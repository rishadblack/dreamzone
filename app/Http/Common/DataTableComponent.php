<?php

namespace App\Http\Common;

use Mpdf\Mpdf;
use Illuminate\Http\Response;
use Mpdf\Tag\Dd;
use PDF;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Eloquent\Model;
use App\Http\Common\LaravelLivewireTables\ExcelExport;
use App\Traits\WithSweetAlert;
use Rappasoft\LaravelLivewireTables\DataTableComponent as BaseDataTableComponent;
// use Illuminate\Http\Response;
use Mpdf\Output\Destination;

abstract class DataTableComponent extends BaseDataTableComponent
{
    use WithSweetAlert;

    public $exportTitle;
    public $exportHeaders = [];
    public $exportPaperSize;
    public $exportOrientation;
    public $exportFileName;
    public $exportPdfLocation;

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

    protected $listeners = [
       'refreshDatatable' => '$refresh',
       'setSort' => 'setSortEvent',
       'clearSorts' => 'clearSortEvent',
       'setFilter' => 'setFilterEvent',
       'clearFilters' => 'clearFilterEvent',
       'clearDatatable' => 'clearDatatable',
    ];

    public function clearDatatable()
    {
        $this->dispatchBrowserEvent('typeahead_reset');
        $this->clearFilterEvent();
        $this->clearSorts();
        $this->clearSearch();
    }


    public function export($format = 'xlsx')
    {
        $this->exportConfigure();

        if ($format == 'pdf') {
            $formarLoader = \Maatwebsite\Excel\Excel::MPDF;
        } else {
            $formarLoader = \Maatwebsite\Excel\Excel::XLSX;
        }

        if (!$this->exportFileName && $this->exportTitle) {
            $this->exportFileName = Str::kebab($this->exportTitle);
        } elseif (!$this->exportFileName && $this->getTableName()) {
            $this->exportFileName = Str::kebab($this->getTableName());
        }




        if ($this->exportPdfLocation && $format == 'pdf') {
            $pdf = PDF::loadView($this->exportPdfLocation, [
                'title' => $this->exportTitle,
                'columns' => $this->getExportColumn(),
                'rows' => $this->getExportQuery($this->getPrimaryKey())->get(),
            ], [
                'title' => 'Another Title',
                'margin_top' => 30
            ]);

            return response()->streamDownload(function () use ($pdf) {
                $pdf->stream();
            }, $this->exportFileName . '-' . now()->format('d-m-y-h-i') . '.' . $format);
        }


        $class = new ExcelExport();
        $class->setTitleText($this->exportTitle);
        $class->setQuery($this->getExportQuery($this->getPrimaryKey()));
        $class->setHeaderText($this->exportHeaders);
        $class->setPaperSize($this->exportPaperSize);
        $class->setOrientation($this->exportOrientation);
        $class->setColumns($this->getExportColumn());

        return Excel::download($class, $this->exportFileName . '-' . now()->format('d-m-y-h-i') . '.' . $format, $formarLoader);
    }

    public function getExportColumn($blockColumn = [])
    {
        if (count($blockColumn) <= 0) {
            $blockColumn = ['Actions'];
        }

        return $this->getColumns()->filter(function ($column) use ($blockColumn) {
            if ($this->columnSelectIsEnabledForColumn($column) && in_array($column->getTitle(), $blockColumn)) {
                return false;
            } elseif ($this->columnSelectIsEnabledForColumn($column)) {
                return true;
            }
            return false;
        });
    }

    public function getExportQuery($column, $limit = null)
    {
        $query = clone $this->baseQuery();

        if (count($this->getSelected()) > 0) {
            $query->whereIn($column, $this->getSelected());
        } elseif ($limit) {
            $query->limit($limit);
        }
        return $query;
    }

    public function getExportColumnSelected()
    {
        return $this->getSelected();
    }

    public function exportConfigure()
    {
        //
    }

    public function setExportTitle($title)
    {
        $this->exportTitle = $title;
        return $this;
    }

    public function setExportHeaders($headers = [])
    {
        $this->exportHeaders = $headers;
        return $this;
    }

    public function setExportPdfLocation($location)
    {
        $this->exportPdfLocation = $location;
        return $this;
    }

    public function setExportPaperSize($paperSize = 9)
    {
        $this->exportPaperSize = $paperSize;
        return $this;
    }

    public function setExportOrientation($orientation = 'default')
    {
        $this->exportOrientation = $orientation;
        return $this;
    }

    public function setExportFileName($fileName = null)
    {
        $this->exportFileName = $fileName;
        return $this;
    }
}
