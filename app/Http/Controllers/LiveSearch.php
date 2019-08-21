<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LiveSearch extends Controller
{
    function index()
    {
//        return view('live_search');
    }

    function action(Request $request)
    {
        if ($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if ($query != '')
            {
                $data = DB::table('items')
                    ->where('name', 'like', '%'.$query.'%')
                    ->orWhere('upc_code', 'like', '%'.$query.'%')
                    ->orWhere('size', 'like', '%'.$query.'%')
                    ->orWhere('net_cost', 'like', '%'.$query.'%')
                    ->orWhere('net_case', 'like', '%'.$query.'%')
                    ->orderBy('slug', 'desc')
                    ->get();

            }
            else
            {
                $data = DB::table('items')
                    ->orderBy('slug', 'desc')
                    ->get();
            }
            $total_row = $data->count();
            if ($total_row > 0)
            {
                foreach ($data as $row)
                {
                    $output .= '
        <tr>
         <td>'.$row->name.'</td>
         <td>'.$row->upc_code.'</td>
         <td>'.$row->size.'</td>
         <td>'.$row->net_cost.'</td>
         <td>'.$row->net_case.'</td>
        </tr>
        ';
                }
            }
            else
            {
                $output = '
       <tr>
        <td align="center" colspan="5">No Data Found</td>
       </tr>
       ';
            }
            $data = array(
                'table_data'  => $output,
                'total_data'  => $total_row
            );

            echo json_encode($data);
        }
    }
}
