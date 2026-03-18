<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-end mb-8 border-b border-slate-100 pb-8">
            <div>
                <h2 class="text-2xl font-black text-slate-900 tracking-tight uppercase">Master Calendar</h2>
                <p class="text-sm text-slate-500 font-medium">Unified view of room stays and garden events.</p>
            </div>
            <div class="flex gap-4">
                <a href="{{ route('admin.front-desk.index') }}" class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-50 transition shadow-sm uppercase tracking-widest">
                    Front Desk View
                </a>
            </div>
        </div>

        <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm p-8">
            <!-- Status Legend -->
            <div class="flex flex-wrap gap-8 mb-10 p-6 bg-slate-50 rounded-2xl border border-slate-100">
                <div class="space-y-3">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Accommodation (Rooms)</p>
                    <div class="flex flex-wrap gap-6">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-[#10b981]"></div>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-600">In-House</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-[#f59e0b]"></div>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-600">Arrival Today</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-[#3b82f6]"></div>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-600">Confirmed Booking</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-[#ef4444]"></div>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-600">Pending Request</span>
                        </div>
                    </div>
                </div>
                
                <div class="w-px bg-slate-200 self-stretch hidden md:block"></div>

                <div class="space-y-3">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Public Spaces</p>
                    <div class="flex flex-wrap gap-6">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-md bg-[#10b981] ring-2 ring-[#064e3b]/20"></div>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-600">Garden Booking</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-md bg-[#e11d48] ring-2 ring-[#881337]/20"></div>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-600">Other Event</span>
                        </div>
                    </div>
                </div>
            </div>

            <div id="calendar" class="min-h-[700px]"></div>
        </div>
    </div>

    @push('styles')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
    <style>
        .fc {
            --fc-border-color: #f1f5f9;
            --fc-button-bg-color: #0f172a;
            --fc-button-border-color: #0f172a;
            --fc-button-hover-bg-color: #1e293b;
            --fc-button-hover-border-color: #1e293b;
            --fc-button-active-bg-color: #334155;
            --fc-button-active-border-color: #334155;
            --fc-event-border-color: transparent;
            --fc-today-bg-color: #f8fafc;
            --fc-page-bg-color: transparent;
            font-family: 'Inter', sans-serif !important;
        }
        .fc .fc-toolbar-title {
            font-size: 1.1rem !important;
            font-weight: 800 !important;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }
        .fc .fc-col-header-cell {
            padding: 16px 0 !important;
            background: #f8fafc;
            font-weight: 800;
            color: #64748b;
            text-transform: uppercase;
            font-size: 0.65rem;
            letter-spacing: 0.1em;
            border-bottom: 2px solid #e2e8f0 !important;
        }
        .fc .fc-daygrid-day-number {
            font-size: 0.75rem;
            font-weight: 700;
            color: #94a3b8;
            padding: 10px;
        }
        .fc-event {
            cursor: pointer;
            padding: 4px 8px !important;
            border-radius: 8px !important;
            font-size: 0.65rem !important;
            font-weight: 800 !important;
            text-transform: uppercase;
            letter-spacing: 0.025em;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1) !important;
            margin: 2px 0 !important;
            border: none !important;
        }
        .fc-day-today .fc-daygrid-day-number {
            color: #4f46e5;
            font-weight: 900;
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
                displayEventTime: true,
                eventDidMount: function(info) {
                    let props = info.event.extendedProps;
                    let tooltip = `TYPE: ${props.type}\nGUEST: ${props.guest}\n`;
                    if(props.rooms) tooltip += `ROOMS: ${props.rooms}\n`;
                    tooltip += `STATUS: ${props.status || 'Active'}`;
                    info.el.title = tooltip;
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
