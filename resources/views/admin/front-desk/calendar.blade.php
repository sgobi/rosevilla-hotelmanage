<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Reservation Calendar
            </h2>
            <div class="flex gap-4">
                <a href="{{ route('admin.front-desk.index') }}" class="bg-white border border-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-50 transition">
                    Back to Terminal
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 p-8">
                <!-- Status Legend -->
                <div class="flex flex-wrap gap-6 mb-8 pb-6 border-b border-gray-100">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-[#10b981]"></div>
                        <span class="text-xs font-bold uppercase tracking-wider text-gray-600">In-House</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-[#f59e0b]"></div>
                        <span class="text-xs font-bold uppercase tracking-wider text-gray-600">Confirmed Arrival</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-[#3b82f6]"></div>
                        <span class="text-xs font-bold uppercase tracking-wider text-gray-600">Future Booking</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-[#6b7280]"></div>
                        <span class="text-xs font-bold uppercase tracking-wider text-gray-600">Checked Out</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-[#ef4444]"></div>
                        <span class="text-xs font-bold uppercase tracking-wider text-gray-600">Pending Request</span>
                    </div>
                </div>

                <div id="calendar" class="min-h-[600px]"></div>
            </div>
        </div>
    </div>

    @push('styles')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
    <style>
        .fc {
            --fc-border-color: #f3f4f6;
            --fc-button-bg-color: #4f46e5;
            --fc-button-border-color: #4f46e5;
            --fc-button-hover-bg-color: #4338ca;
            --fc-button-hover-border-color: #4338ca;
            --fc-button-active-bg-color: #3730a3;
            --fc-button-active-border-color: #3730a3;
            --fc-event-border-color: transparent;
            --fc-today-bg-color: #f9fafb;
            font-family: inherit;
        }
        .fc .fc-toolbar-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1f2937;
        }
        .fc .fc-col-header-cell {
            padding: 12px 0;
            background: #f9fafb;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
        }
        .fc .fc-daygrid-day-number {
            font-size: 0.875rem;
            color: #4b5563;
            padding: 8px;
        }
        .fc-event {
            cursor: pointer;
            padding: 3px 6px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 700;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            margin: 1px 0;
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,listMonth'
                },
                events: "{{ route('admin.front-desk.api') }}",
                height: 'auto',
                firstDay: 1,
                displayEventTime: false,
                eventDidMount: function(info) {
                    // Tooltip-like effect using native title
                    info.el.title = `${info.event.extendedProps.rooms}\nGuest: ${info.event.extendedProps.guest}\nDuration: ${info.event.extendedProps.nights} Nights`;
                },
                eventClick: function(info) {
                    if (info.event.url) {
                        window.location.href = info.event.url;
                        info.jsEvent.preventDefault();
                    }
                }
            });
            calendar.render();
        });
    </script>
    @endpush
</x-app-layout>
