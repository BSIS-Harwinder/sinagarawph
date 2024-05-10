<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class OffersController extends Controller
{
    public function index(Request $request) {
        $offers = Offer::query()->get();

        $data = [
            'offers' => $offers
        ];

        return view('pages.quotation.admin.offers.index', compact('data'));
    }

    public function show($id) {
        $offer = Offer::query()->findOrFail($id);

        $data = [
            'offer' => $offer
        ];

        return view('pages.quotation.admin.offers.show', compact('data'));
    }

    public function store(Request $request) {
        try {
            $this->validate($request, [
                'cost' => ['required', 'numeric'],
                'size' => 'required',
                'panels' => ['required', 'numeric'],
                'savings' => ['required', 'numeric']
            ]);
        } catch (ValidationException $exception) {
            return redirect()
                ->back()
                ->withInput($request->all())
                ->withErrors($exception->getMessage());
        }

        try {
            $offer = new Offer($request->all());
            $offer->save();
        } catch (QueryException $exception) {
            return redirect()
                ->back()
                ->withErrors($exception->getMessage());
        }

        return redirect()->route('offers.index')->with('store_success', true);
    }

    public function update($id, Request $request) {
        try {
            $this->validate($request, [
                'cost' => ['required', 'numeric'],
                'size' => 'required',
                'panels' => ['required', 'numeric'],
                'savings' => ['required', 'numeric']
            ]);
        } catch (ValidationException $exception) {
            return redirect()
                ->back()
                ->withInput($request->all())
                ->withErrors($exception->getMessage());
        }

        try {
            $offer = Offer::query()->findOrFail($id);
            $offer->update($request->all());
        } catch (QueryException $exception) {
            return redirect()
                ->back()
                ->withInput($request->all())
                ->withErrors($exception->getMessage());
        }

        return redirect()->route('offers.index')->with('update_success', true);
    }

    public function delete($id) {
        try {
            $offer = Offer::query()->findOrFail($id);
            $offer->delete();
        } catch (QueryException $exception) {
            return redirect()
                ->back()
                ->withErrors($exception->getMessage());
        }

        return redirect()->route('offers.index')->with('delete_success', true);
    }
}
