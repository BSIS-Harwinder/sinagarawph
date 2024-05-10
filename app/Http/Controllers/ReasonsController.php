<?php

namespace App\Http\Controllers;

use App\Models\Reason;
use Illuminate\Http\Request;

class ReasonsController extends Controller
{
    public function index(Request $request) {
        return Reason::query()->get();
    }

    public function show($id) {

    }

    public function store(Request $request) {

    }

    public function update(Request $request) {

    }

    public function delete($id) {

    }
}
