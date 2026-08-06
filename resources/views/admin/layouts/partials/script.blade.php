<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('assets/js/flatpickr.js')}}"></script>
<script src="{{asset('assets/js/select2.min.js')}}"></script>
<script src="{{asset('assets/js/summernote-lite.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/dataTables.bootstrap5.min.js')}}"></script>
<script src="{{asset('assets/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/js/buttons.bootstrap5.min.js')}}"></script>
<script src="{{asset('assets/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/js/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/js/jszip.min.js')}}"></script>
<script src="{{asset('assets/js/pdfmake.min.js')}}"></script>
<script src="{{asset('assets/js/vfs_fonts.js')}}"></script>
<script src="{{asset('assets/js/bootstrap-select.min.js')}}"></script>
<script src="{{asset('assets/js/lightgallery.min.js')}}"></script>
<script src="{{asset('assets/js/lg-zoom.min.js')}}"></script>
<script src="{{asset('assets/js/lg-thumbnail.min.js')}}"></script>
<script src="{{asset('assets/js/lg-fullscreen.min.js')}}"></script>
<script src="{{asset('assets/js/lg-autoplay.min.js')}}"></script>
<script src="{{asset('assets/js/lg-share.min.js')}}"></script>
<script src="{{asset('assets/js/lg-pager.min.js')}}"></script>
<script src="{{asset('assets/js/lg-hash.min.js')}}"></script>
<script src="{{asset('assets/js/swiper-bundle.min.js')}}"></script>
<script src="{{asset('assets/js/gallery.js')}}"></script>
<script src="{{asset('assets/js/preloader.js')}}"></script>
<script src="{{asset('assets/js/swiper_slider.js')}}"></script>
<script src="{{asset('assets/js/script.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let sortable = new Sortable(document.getElementById('sortable-permissions'), {
            animation: 150,
            handle: '.cursor-move', // Only drag using the icon
            onEnd: function() {
                let order = [];
                document.querySelectorAll('#sortable-permissions tr').forEach((row, index) => {
                    order.push({
                        id: row.getAttribute('data-id'),
                        order_no: index + 1
                    });
                });

                fetch("{{ route('admin.permissions.reorder') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            order: order
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        console.log("Order updated:", data);
                    });
            }
        });

    });
</script>
<script>
    // Summernote Text Editor
    $(document).ready(function() {
        $("#summernote").summernote({
            height: 200,
        });
    });
</script>
@stack('scripts')