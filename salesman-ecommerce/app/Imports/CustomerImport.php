<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;

class CustomerImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $data = explode("!3d",$row[0]);
        $ll = explode("!4d",$data[1] ?? 1);
        $long = $ll[1] ??  1;
        $lat = $ll[0] ??  1;
        return new Customer([
            'customer_id' => $row[5],
            'name' => $row[1],
            'owner' => $row[1],
            'phone' => $row[3],
            'address' => $row[2],
            'lat' => $lat,
            'long' => $long,
            'area_id' => $row[6] ?? 1,
            'images' => $row[4],
        ]);
    }
}
