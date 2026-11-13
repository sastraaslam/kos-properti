<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AssetController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->trim()->toString();
        $category = $request->query('category');
        $condition = $request->query('condition');

        $assets = Asset::query()
            ->when($search !== '', function (Builder $query) use ($search): void {
                $query->where(function (Builder $query) use ($search): void {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('location', 'like', "%{$search}%");
                });
            })
            ->when(in_array($category, Asset::CATEGORIES, true), fn (Builder $query) => $query->where('category', $category))
            ->when(in_array($condition, Asset::CONDITIONS, true), fn (Builder $query) => $query->where('asset_condition', $condition))
            ->latest()
            ->paginate(8)
            ->withQueryString();

        return view('assets.index', [
            'assets' => $assets,
            'categories' => Asset::CATEGORIES,
            'conditions' => Asset::CONDITIONS,
            'search' => $search,
            'selectedCategory' => $category,
            'selectedCondition' => $condition,
            'totalUnits' => Asset::query()->sum('quantity'),
            'totalCategories' => Asset::query()->distinct()->count('category'),
            'totalValue' => Asset::query()->selectRaw('COALESCE(SUM(quantity * price), 0) as aggregate')->value('aggregate'),
            'attentionCount' => Asset::query()->whereIn('asset_condition', ['Perlu Perbaikan', 'Rusak'])->count(),
        ]);
    }

    public function create(): View
    {
        return view('assets.form', [
            'asset' => new Asset,
            'categories' => Asset::CATEGORIES,
            'conditions' => Asset::CONDITIONS,
            'statuses' => Asset::STATUSES,
            'pageTitle' => 'Tambah aset',
            'submitLabel' => 'Simpan aset',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $asset = Asset::create($this->validatedData($request));

        return redirect()->route('assets.show', $asset)->with('success', 'Aset berhasil ditambahkan.');
    }

    public function show(Asset $asset): View
    {
        return view('assets.show', compact('asset'));
    }

    public function edit(Asset $asset): View
    {
        return view('assets.form', [
            'asset' => $asset,
            'categories' => Asset::CATEGORIES,
            'conditions' => Asset::CONDITIONS,
            'statuses' => Asset::STATUSES,
            'pageTitle' => 'Ubah aset',
            'submitLabel' => 'Simpan perubahan',
        ]);
    }

    public function update(Request $request, Asset $asset): RedirectResponse
    {
        $asset->update($this->validatedData($request));

        return redirect()->route('assets.show', $asset)->with('success', 'Perubahan aset berhasil disimpan.');
    }

    public function destroy(Asset $asset): RedirectResponse
    {
        $asset->delete();

        return redirect()->route('assets.index')->with('success', 'Aset berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedData(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'category' => ['required', 'in:'.implode(',', Asset::CATEGORIES)],
            'location' => ['required', 'string', 'max:120'],
            'quantity' => ['required', 'integer', 'min:1', 'max:100000'],
            'asset_condition' => ['required', 'in:'.implode(',', Asset::CONDITIONS)],
            'status' => ['required', 'in:'.implode(',', Asset::STATUSES)],
            'purchase_date' => ['nullable', 'date'],
            'price' => ['required', 'numeric', 'min:0', 'max:999999999999.99'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);
    }
}
