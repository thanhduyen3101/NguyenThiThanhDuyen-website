<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Item;

class ItemController extends Controller
{
    //
    function addItem(Request $req) 
    {
        $item = new Item();

        $item->name = $req->name;
        $item->category = $req->category;
        $item->description = $req->description;
        $item->price = $req->price;
        $item->image = $req->file('image')->store('items');

        $item->save();

        return $item;
    }

    function editItem(Request $req) 
    {
        
    }

    function listItem()
    {
        return Item::all();
    }
}
