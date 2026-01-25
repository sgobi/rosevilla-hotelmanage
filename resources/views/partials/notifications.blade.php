@if($notifications->count() > 0)
    <div class="mb-6 bg-white shadow rounded-xl border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-indigo-50 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-indigo-900 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                    <path fill-rule="evenodd" d="M5.25 9a6.75 6.75 0 0113.5 0v.75c0 2.123.8 4.057 2.118 5.52a.75.75 0 01-.297 1.206c-1.544.57-3.16.99-4.831 1.243a3.75 3.75 0 11-7.48 0 24.585 24.585 0 01-4.831-1.244.75.75 0 01-.298-1.205A8.217 8.217 0 005.25 9.75V9zm4.502 8.9a2.25 2.25 0 104.496 0 25.057 25.057 0 01-4.496 0z" clip-rule="evenodd" />
                </svg>
                New Notifications
            </h3>
            <form action="{{ route('notifications.markRead') }}" method="POST">
                @csrf
                <button class="text-xs text-indigo-600 hover:text-indigo-800 font-semibold uppercase">Mark all as read</button>
            </form>
        </div>
        <div class="divide-y divide-gray-100">
            @foreach($notifications as $notification)
                @php
                    $data = $notification->data;
                    $type = $data['type'] ?? 'info';
                    $subtype = $data['subtype'] ?? '';
                    $status = $data['status'] ?? '';
                @endphp
                <div class="px-6 py-4 flex items-start justify-between hover:bg-gray-50 transition">
                    <div class="flex gap-3">
                        <div class="mt-1">
                            @if($type === 'discount_suggestion' || $subtype === 'discount')
                                <span class="bg-amber-100 text-amber-800 text-xs px-2 py-1 rounded-full font-bold">Discount</span>
                            @elseif($type === 'reprint_request' || $subtype === 'reprint')
                                <span class="bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded-full font-bold">Reprint</span>
                            @elseif($subtype === 'status')
                                <span class="bg-orange-100 text-orange-800 text-xs px-2 py-1 rounded-full font-bold">Status</span>
                            @elseif($subtype === 'conflict')
                                <span class="bg-rose-100 text-rose-800 text-xs px-2 py-1 rounded-full font-bold">Conflict</span>
                            @elseif($status === 'approved')
                                <span class="bg-emerald-100 text-emerald-800 text-xs px-2 py-1 rounded-full font-bold">Approved</span>
                            @elseif($status === 'rejected')
                                <span class="bg-rose-100 text-rose-800 text-xs px-2 py-1 rounded-full font-bold">Rejected</span>
                            @else
                                <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full font-bold">Update</span>
                            @endif
                        </div>
                        <div>
                            <p class="text-gray-900 font-medium">{{ $data['message'] ?? 'Notification' }}</p>
                            <p class="text-xs text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    @if(isset($data['action_url']))
                        <a href="{{ route('notifications.read', $notification->id) }}" class="text-sm text-gray-500 hover:text-gray-900 flex items-center gap-1">
                            View
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                            </svg>
                        </a>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endif
