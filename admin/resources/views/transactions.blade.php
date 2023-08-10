<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Transactions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        @if (count($transactions) >= 1)
            @foreach ($transactions as $transaction)
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table>
                    <tr>
                        <td>{{$transaction->id}}</td>
                        <td>{{$transaction->sale_id}}</td>
                        <td>{{$transaction->total_price}}</td>
                        <td>{{$transaction->total_points}}</td>
                    </tr>
                    </table>
                    </div>
                </div>
            </div>  
            @endforeach
        @else
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        {{$result}}
                    </div>
                </div>
            </div>  
        @endif
        

    </div>     
</x-app-layout>
