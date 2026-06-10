<?php

namespace App\Http\Controllers;

use App\Support\DemoData;

class PrototypeController extends Controller
{
    public function dashboard()
    {
        return view('dashboard', ['chart' => DemoData::chart()]);
    }

    public function units()
    {
        return view('units.index', [
            'units'  => DemoData::units(),
            'status' => DemoData::statusMap(),
        ]);
    }

    public function unit(string $code)
    {
        $unit = DemoData::unit($code);
        abort_if(! $unit, 404);

        return view('units.show', [
            'unit'     => $unit,
            'status'   => DemoData::statusMap(),
            'timeline' => DemoData::unitTimeline($unit['status']),
            'trx'      => DemoData::transactionForUnit($code),
            'docs'     => DemoData::unitDocs($unit['status'], $unit['bayar']),
            'stages'   => DemoData::stages(),
        ]);
    }

    public function pipeline()
    {
        return view('pipeline.index', [
            'stages' => DemoData::stages(),
            'deals'  => DemoData::transactions(),
        ]);
    }

    public function transaction(int $id)
    {
        $trx = DemoData::transaction($id);
        abort_if(! $trx, 404);

        return view('pipeline.show', [
            'trx'      => $trx,
            'stages'   => DemoData::stages(),
            'states'   => DemoData::pipelineStates($trx),
            'schedule' => DemoData::trxSchedule($trx),
            'docs'     => DemoData::trxDocs($trx),
        ]);
    }

    public function invoices()
    {
        return view('invoices.index', [
            'invoices' => DemoData::invoices(),
            'status'   => DemoData::invoiceStatusMap(),
        ]);
    }

    public function tipe()
    {
        return view('tipe.index', ['tipe' => DemoData::tipe()]);
    }
}
