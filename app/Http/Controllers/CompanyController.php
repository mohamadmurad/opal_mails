<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::paginate();

        return view('company.index',compact('companies'));
    }


    public function create(){

        return view('company.create');
    }

    public function store(StoreCompanyRequest $request)
    {

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $extension = $logo->getClientOriginalExtension();
            $fileName = Str::slug( $request->get('name')) . '.' .$extension;
            $dd= Storage::disk('logo')->put($fileName,  File::get($logo));
        }

           

        $company = Company::create([
            'name' => $request->get('name'),
            'logo' => $fileName,
        ]);

        return Redirect::route('companies.index');

    }


    public function show(Request $request, Company $company){

        //return view('company.show',compact('company'));
    }


    public function edit(Company $company){

        return view('company.edit',compact('company'));
    }


    public function update(UpdateCompanyRequest $request , Company $company){

        $company->fill([
            'name' => $request->get('name'),
        ]);

        $company->save();

        return Redirect::route('companies.index')
            ->with('success','Company Updated successfully.');

    }

    public function destroy(Company $company){

        $company->delete();
        return Redirect::route('companies.index')
            ->with('success','Company Deleted successfully.');


    }
}
