<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Contact\Contact;
use App\Models\Product\Product;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        if ($request->type == 'products') {
            return $this->searchProducts();
        }
        if ($request->type == 'customers') {
            return $this->searchCustomers();
        }
        if ($request->type == 'suppliers') {
            return $this->searchSuppliers();
        }
        if ($request->type == 'billers') {
            return $this->searchBillers();
        }
        if ($request->type == 'stuffs') {
            return $this->searchStuffs();
        }
        if ($request->type == 'ledgeraccounts') {
            return $this->searchLedgerAccounts();
        }

        return collect([]);
    }

    public function searchProducts()
    {
        $query = Product::query();

        // if (request()->has('client_type') && request()->filled('client_type')) {
        //     $query->whereType(request()->client_type);
        // }

        // if (request()->has('client_type_only') && request()->filled('client_type_only')) {
        //     $query->whereIn('type', explode(',', request()->client_type_only));
        // }

        $query->select('id', 'code', 'name');
        $query->limit(10);

        if (request()->has('search') && request()->filled('search')) {
            $query->search(request()->search);
        }

        $query = $query->get()->map(function ($item, $key) {
            $item['id'] = $item->id;
            $item['name'] = $item->name;
            $item['code'] = $item->code;
            $item['search'] = request()->search;
            return $item;
        });

        return response()->json($query);
    }

    //Customers
    public function searchCustomers()
    {
        $query = Contact::query();

        $query->select('id', 'code', 'company_name');
        $query->limit(10);

        if (request()->has('search') && request()->filled('search')) {
            $query->search(request()->search);
        }

        $query = $query->get()->map(function ($item, $key) {
            $item['id'] = $item->id;
            //$item['name'] = $item->name;
            $item['code'] = $item->code;
            $item['company_name'] = $item->company_name;
            $item['search'] = request()->search;
            return $item;
        });

        return response()->json($query);
    }
    //Billers
    public function searchBillers()
    {
        $query = Contact::query();

        $query->select('id', 'code', 'company_name');
        $query->limit(10);

        if (request()->has('search') && request()->filled('search')) {
            $query->search(request()->search);
        }

        $query = $query->get()->map(function ($item, $key) {
            $item['id'] = $item->id;
            //$item['name'] = $item->name;
            $item['code'] = $item->code;
            $item['company_name'] = $item->company_name;
            $item['search'] = request()->search;
            return $item;
        });

        return response()->json($query);
    }
    //Suppliers
    public function searchSuppliers()
    {
        $query = Contact::query();

        $query->select('id', 'code', 'company_name');
        $query->limit(10);

        if (request()->has('search') && request()->filled('search')) {
            $query->search(request()->search);
        }

        $query = $query->get()->map(function ($item, $key) {
            $item['id'] = $item->id;
            //$item['name'] = $item->name;
            $item['code'] = $item->code;
            $item['company_name'] = $item->company_name;
            $item['search'] = request()->search;
            return $item;
        });

        return response()->json($query);
    }
    //Stuffs
    public function searchStuffs()
    {
        $query = Contact::query();

        $query->select('id', 'code', 'company_name');
        $query->limit(10);

        if (request()->has('search') && request()->filled('search')) {
            $query->search(request()->search);
        }

        $query = $query->get()->map(function ($item, $key) {
            $item['id'] = $item->id;
            //$item['name'] = $item->name;
            $item['code'] = $item->code;
            $item['company_name'] = $item->company_name;
            $item['search'] = request()->search;
            return $item;
        });

        return response()->json($query);
    }

    //Ledger Account
    public function searchLedgerAccounts()
    {
        $query = Contact::query();

        $query->select('id', 'code', 'name');
        $query->limit(10);

        if (request()->has('search') && request()->filled('search')) {
            $query->search(request()->search);
        }

        $query = $query->get()->map(function ($item, $key) {
            $item['id'] = $item->id;
            //$item['name'] = $item->name;
            $item['code'] = $item->code;
            $item['name'] = $item->company_name;
            $item['search'] = request()->search;
            return $item;
        });

        return response()->json($query);
    }
}
