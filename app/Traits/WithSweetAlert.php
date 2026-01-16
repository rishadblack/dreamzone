<?php

namespace App\Traits;

use Jantinnerezo\LivewireAlert\LivewireAlert;

trait WithSweetAlert
{
    use LivewireAlert;

    public function alertConfirm(array $data, $title = false, $options = [])
    {
        if(!$title) {
            $title = __('default.are_you_sure');
        }

        if (!isset($data['isConfirmed']) && isset($data['listener'])) {

            $this->alert('warning', $title, array_merge(
                [
                    'position' => 'center',
                    'timer' => '',
                    'showConfirmButton' => true,
                    'onConfirmed' => $data['listener'],
                    'showCancelButton' => true,
                    'confirmButtonText' => 'Yes',
                    'inputAttributes' => $data
                ],
                $options,
            ));
            return false;
        } elseif ($data['inputAttributes']) {
            return $data['inputAttributes'];
        }
    }
}
