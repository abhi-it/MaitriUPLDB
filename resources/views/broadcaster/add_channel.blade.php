@extends('broadcaster.layout.header')
@section('content')
<div class="container d-flex justify-content-center align-items-center" style="height: 80vh;">
    <div class="card shadow-lg p-4" style="width: 800px; background-color: white; border-radius: 10px;">
        <h3 class="text-center fw-bold mb-4">Create New Channel</h3>
        
        <form action="{{ route('createChannel') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Channel Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="mb-3">
                <label for="latency_mode" class="form-label">Latency Mode</label>
                <select class="form-control" id="latency_mode" name="latency_mode" required>
                    <option value="LOW">Low</option>
                    <option value="NORMAL">Normal</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="type" class="form-label">Channel Type</label>
                <select class="form-control" id="type" name="type" required>
                    <option value="BASIC">Basic</option>
                    <option value="STANDARD">Standard</option>
                    <option value="ADVANCED_SD">Advanced SD</option>
                    <option value="ADVANCED_HD">Advanced HD</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary w-100">Create Channel</button>
        </form> 
    </div>
</div>

@endsection

