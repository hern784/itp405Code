<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Models\Invoice;

class InvoiceController extends Controller
{
    //
    public function index()
    {
        // OLD WAY 
        /*
         *$invoices = DB::table('invoices')
         *    ->join('customers', 'invoices.customer_id', '=', 'customers.id')
         *    ->get([
         *        'invoices.id AS id',
         *        'invoice_date',
         *        'first_name',
         *        'last_name',
         *        'total',
         *    ]);
         *return view('invoice.index', [
         *    'invoices' => $invoices
         *]);
         */

        //$invoices = Invoice::all(); //SLOW because N+1 queries

        // NEW WAY USING ELOQUENT
        $invoices = Invoice::with(['customer'])->get();

        return view('invoice.index', [
            'invoices' => $invoices
        ]);
    }

    public function show($id)
    {
        // OLD WAY 
        /*
 *        $invoice = DB::table('invoices')
 *            ->where('id', '=', $id)
 *            ->first();
 *
 *        $invoiceItems = DB::table('invoice_items')
 *            ->where('invoice_id', '=', $id)
 *            ->join('tracks', 'tracks.id', '=', 'invoice_items.track_id')
 *            ->join('albums', 'tracks.album_id', '=', 'albums.id')
 *            ->join('artists', 'albums.artist_id', '=', 'artists.id')
 *            ->get([
 *                'invoice_items.unit_price',
 *                'tracks.name as track',
 *                'albums.title as album',
 *                'artists.name as artist',
 *            ]);
 */

        // NEW WAY USING ELLOQUENT
        $invoice = Invoice::with([
            'invoiceItems.track',
            'invoiceItems.track.album',
            'invoiceItems.track.album.artist',
        ])->find($id);

        return view('invoice.show', [
            'invoice' => $invoice,
            //'invoiceItems' => $invoiceItems,
        ]);
    }
}
