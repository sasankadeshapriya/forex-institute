@extends('layouts.home')

@section('content')
    <section class="py-12 md:py-20 bg-gradient-to-b from-black/10 to-black/30">
        <div class="container mx-auto px-4 max-w-6xl">
            <!-- Alert Message -->
            <div class="bg-yellow-600/20 border border-yellow-600 text-yellow-400 px-4 py-3 rounded-lg mb-6">
                <strong>Attention!</strong> {{ $message }}
            </div>
        </div>
    </section>
@endsection
