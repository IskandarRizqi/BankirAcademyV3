<?php

namespace App\Http\Controllers\MemberNonAnggota;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyLocationController extends Controller
{
    public function cities(Request $request)
    {
        return $this->options($request, 'kota', 'provinsi_id');
    }

    public function districts(Request $request)
    {
        return $this->options($request, 'kecamatan', 'kota_id');
    }

    public function villages(Request $request)
    {
        return $this->options($request, 'kelurahan', 'kecamatan_id');
    }

    private function options(Request $request, string $table, string $parentColumn)
    {
        $parentId = $request->integer('parent_id');
        $search = trim((string) $request->query('q'));

        if ($parentId < 1) {
            return response()->json([
                'results' => [],
                'pagination' => ['more' => false],
            ]);
        }

        $options = DB::table($table)
            ->select(['id', 'name'])
            ->where($parentColumn, $parentId)
            ->when($search !== '', fn ($query) => $query->where('name', 'like', '%'.$search.'%'))
            ->orderBy('name')
            ->paginate(20);

        return response()->json([
            'results' => $options->getCollection()
                ->map(fn ($option) => [
                    'id' => $option->id,
                    'text' => $option->name,
                ])
                ->values(),
            'pagination' => [
                'more' => $options->hasMorePages(),
            ],
        ]);
    }
}
