<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
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

        $this->authorize('viewAny', Invoice::class);

        // NEW WAY USING ELOQUENT
        $invoices = Invoice::select('invoices.*')
            ->with(['customer'])
            ->join('customers', 'invoices.customer_id', '=', 'customers.id')
            ->when(!Auth::user()->isAdmin(), function ($query) {
                return $query->where('customers.email', '=', Auth::user()->email);
            })
            ->get();

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

        // all the same
        /*
         if (Gate::denies('view-invoice', $invoice)) {
             abort(403);
        }
 
         if (!Gate::allows('view-invoice', $invoice)) {
             abort(403);
         }

        if (!Auth::user()->can('view-invoice', $invoice)) {
            abort(403);
        }

        if (Auth::user()->cannot('view-invoice', $invoice)) {
            abort(403);
        }

        $this->authorize('view-invoice', $invoice);
 */

        // using InvoicePolicy to authorize
        $this->authorize('view', $invoice);

        return view('invoice.show', [
            'invoice' => $invoice,
            //'invoiceItems' => $invoiceItems,
        ]);
    }
}
