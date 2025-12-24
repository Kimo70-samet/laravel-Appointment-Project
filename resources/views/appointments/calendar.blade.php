@extends('layouts.app')

@push('styles')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css' rel='stylesheet' />
<style>
    .fc {
        direction: ltr;
    }
    .fc-toolbar-title {
        font-family: 'Cairo', sans-serif !important;
    }
    .fc-event {
        border-radius: 8px;
        border: none;
        padding: 2px 5px;
    }
    .fc-daygrid-event {
        font-size: 12px;
        font-weight: 600;
    }
    .calendar-container {
        background: white;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-calendar-alt me-2"></i>تقويم المواعيد
                    </h4>
                    <div>
                        <a href="{{ route('appointments.create') }}" class="btn btn-primary me-2">
                            <i class="fas fa-plus me-2"></i>إضافة موعد
                        </a>
                        <a href="{{ route('appointments.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-list me-2"></i>عرض القائمة
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="calendar-container">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Appointment Details Modal -->
<div class="modal fade" id="appointmentModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-calendar-check me-2"></i>تفاصيل الموعد
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="appointment-details"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                <a href="#" id="edit-appointment" class="btn btn-warning">
                    <i class="fas fa-edit me-2"></i>تعديل
                </a>
                <a href="#" id="view-appointment" class="btn btn-primary">
                    <i class="fas fa-eye me-2"></i>عرض التفاصيل
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var appointments = @json($appointments);
    
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'ar',
        direction: 'rtl',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        buttonText: {
            today: 'اليوم',
            month: 'شهر',
            week: 'أسبوع',
            day: 'يوم'
        },
        events: appointments,
        eventClick: function(info) {
            showAppointmentDetails(info.event);
        },
        eventMouseEnter: function(info) {
            info.el.style.cursor = 'pointer';
        },
        height: 'auto',
        eventDisplay: 'block',
        dayMaxEvents: 3,
        moreLinkText: function(num) {
            return '+ ' + num + ' المزيد';
        }
    });
    
    calendar.render();
    
    function showAppointmentDetails(event) {
        var appointmentId = event.id;
        var title = event.title;
        var start = event.start;
        var end = event.end;
        
        var startFormatted = start.toLocaleDateString('ar-SA') + ' ' + start.toLocaleTimeString('ar-SA', {hour: '2-digit', minute:'2-digit'});
        var endFormatted = end.toLocaleDateString('ar-SA') + ' ' + end.toLocaleTimeString('ar-SA', {hour: '2-digit', minute:'2-digit'});
        
        var duration = Math.round((end - start) / (1000 * 60)); // Duration in minutes
        
        var detailsHtml = `
            <div class="row">
                <div class="col-12 mb-3">
                    <h5 class="text-primary">
                        <i class="fas fa-tag me-2"></i>${title}
                    </h5>
                </div>
                <div class="col-md-6">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <h6 class="text-success">
                                <i class="fas fa-play me-2"></i>وقت البداية
                            </h6>
                            <p class="mb-0">${startFormatted}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <h6 class="text-danger">
                                <i class="fas fa-stop me-2"></i>وقت النهاية
                            </h6>
                            <p class="mb-0">${endFormatted}</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-3">
                    <div class="alert alert-info text-center">
                        <i class="fas fa-clock me-2"></i>
                        <strong>مدة الموعد: </strong>${duration} دقيقة
                    </div>
                </div>
            </div>
        `;
        
        document.getElementById('appointment-details').innerHTML = detailsHtml;
        document.getElementById('edit-appointment').href = `/appointments/${appointmentId}/edit`;
        document.getElementById('view-appointment').href = `/appointments/${appointmentId}`;
        
        var modal = new bootstrap.Modal(document.getElementById('appointmentModal'));
        modal.show();
    }
});
</script>
@endpush