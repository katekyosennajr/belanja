@extends('layouts.app')

@section('title', 'Kelola Pesanan')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Daftar Pesanan</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID Pesanan</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Pelanggan</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Total</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tanggal</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pesanans as $pesanan)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">#{{ $pesanan->id }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <h6 class="mb-0 text-sm">{{ $pesanan->user->name }}</h6>
                                            <p class="text-xs text-secondary mb-0">{{ $pesanan->user->email }}</p>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">Rp {{ number_format($pesanan->total, 0, ',', '.') }}</p>
                                    </td>
                                    <td>
                                        <span class="badge badge-sm bg-gradient-{{ 
                                            $pesanan->status == 'pending' ? 'warning' : 
                                            ($pesanan->status == 'proses' ? 'info' : 
                                            ($pesanan->status == 'selesai' ? 'success' : 'danger')) 
                                        }}">
                                            {{ ucfirst($pesanan->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-secondary text-xs font-weight-bold">{{ $pesanan->created_at->format('d/m/Y H:i') }}</span>
                                    </td>
                                    <td class="align-middle">
                                        <a href="{{ route('admin.pesanan.show', $pesanan) }}" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Lihat detail">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="px-3 mt-3">
                        {{ $pesanans->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
