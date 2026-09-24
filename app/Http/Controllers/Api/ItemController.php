<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ItemNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreItemRequest;
use App\Models\Item;
use App\Services\ItemService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function __construct(
        protected ItemService $itemService
    ) {}

    /**
     * Display a listing of BMN items with search and filters.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Item::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                    ->orWhere('kode_bmn', 'like', "%{$search}%")
                    ->orWhere('lokasi_simpan', 'like', "%{$search}%");
            });
        }

        if ($kategori = $request->input('kategori')) {
            $query->where('kategori', $kategori);
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $items = $query->latest()->paginate($request->integer('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $items->items(),
            'meta' => [
                'current_page' => $items->currentPage(),
                'last_page' => $items->lastPage(),
                'per_page' => $items->perPage(),
                'total' => $items->total(),
            ],
        ]);
    }

    /**
     * Scan an item by QR code / BMN code.
     */
    public function scan(string $kode_bmn): JsonResponse
    {
        try {
            $item = $this->itemService->findByKodeBmn($kode_bmn);
            $item->load(['transactions' => fn ($q) => $q->latest()->limit(3)]);

            return response()->json([
                'success' => true,
                'data' => $item,
            ]);
        } catch (ItemNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'error' => 'ITEM_NOT_FOUND',
            ], 404);
        }
    }

    /**
     * Get detail of a specific item.
     */
    public function show(Item $item): JsonResponse
    {
        $item->load(['transactions', 'reports']);

        return response()->json([
            'success' => true,
            'data' => $item,
        ]);
    }

    /**
     * Store a newly created item (Admin only via StoreItemRequest).
     */
    public function store(StoreItemRequest $request): JsonResponse
    {
        $item = $this->itemService->createItem($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Barang BMN berhasil didaftarkan.',
            'data' => $item,
        ], 201);
    }
}
