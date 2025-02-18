@extends('layouts.app')

@section('title', 'Detail Pelanggan')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Detail Pelanggan</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-uppercase text-body text-xs font-weight-bolder">Informasi Pelanggan</h6>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item px-0">
                                    <strong class="text-dark">Nama:</strong> {{ $user->name }}
                                </li>
                                <li class="list-group-item px-0">
                                    <strong class="text-dark">Email:</strong> {{ $user->email }}
                                </li>
                                <li class="list-group-item px-0">
                                    <strong class="text-dark">Telepon:</strong> {{ $user->telepon ?? '-' }}
                                </li>
                                <li class="list-group-item px-0">
                                    <strong class="text-dark">Alamat:</strong> {{ $user->alamat ?? '-' }}
                                </li>
                                <li class="list-group-item px-0">
                                    <strong class="text-dark">Bergabung:</strong> {{ $user->created_at->format('d/m/Y') }}
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-uppercase text-body text-xs font-weight-bolder">Statistik Pesanan</h6>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item px-0">
                                    <strong class="text-dark">Total Pesanan:</strong> {{ $user->pesanans->count() }}
                                </li>
                                <li class="list-group-item px-0">
                                    <strong class="text-dark">Pesanan Selesai:</strong> 
                                    {{ $user->pesanans->where('status', 'selesai')->count() }}
                                </li>
                                <li class="list-group-item px-0">
                                    <strong class="text-dark">Pesanan Dalam Proses:</strong>
                                    {{ $user->pesanans->whereIn('status', ['pending', 'proses'])->count() }}
                                </li>
                                <li class="list-group-item px-0">
                                    <strong class="text-dark">Total Pembelian:</strong>
                                    Rp {{ number_format($user->pesanans->sum('total'), 0, ',', '.') }}
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-3">Riwayat Pesanan</h6>
                            <div class="table-responsive">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID Pesanan</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Total</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tanggal</th>
                                            <th class="text-secondary opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($user->pesanans as $pesanan)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">#{{ $pesanan->id }}</h6>
                                                    </div>
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
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('admin.pelanggan.index') }}" class="btn btn-secondary">Kembali ke Daftar Pelanggan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
