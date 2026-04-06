@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto">

        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('tickets.index') }}"
                class="w-8 h-8 flex items-center justify-center rounded-full bg-white shadow hover:bg-gray-50 text-gray-500">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h1 class="text-2xl font-bold text-gray-800">Create New Ticket</h1>
        </div>

        <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
            <form action="{{ route('tickets.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Requester Name <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="requester_name" placeholder="John Doe" required
                        class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Subject / Problem Issue <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="subject" placeholder="E.g., Cannot access dashboard..." required
                        class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all">
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Priority</label>
                        <select name="priority"
                            class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:border-primary">
                            <option value="Low">Low</option>
                            <option value="Medium">Medium</option>
                            <option value="High">High</option>
                            <option value="Critical">Critical</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Channel</label>
                        <select name="channel"
                            class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:border-primary">
                            <option value="Web">Web Dashboard</option>
                            <option value="Email">Email Support</option>
                            <option value="Outlook">Outlook</option>
                        </select>
                    </div>
                </div>

                <hr class="border-gray-100 my-6">

                <div class="flex justify-end gap-3">
                    <a href="{{ route('tickets.index') }}"
                        class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium">Cancel</a>
                    <button type="submit"
                        class="px-6 py-2.5 bg-primary text-white rounded-lg hover:bg-teal-600 font-medium shadow-md shadow-primary/30">Submit
                        Ticket</button>
                </div>
            </form>
        </div>
    </div>
@endsection