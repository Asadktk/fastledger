@extends('admin.layout.app')

<style>
    #file-table tbody tr {
    cursor: pointer;
}


</style>
@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">
            <!-- Page Header -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-header     justify-content-between ">
                            <h4 class="card-title">File Opening Book</h4>
                            <div class="d-flex doc_button">
                                <a href="{{ route('files.create') }}" class="btn addbutton" role="button">
                                    <i class="fas fa-plus"></i> Add File
                                </a>     
                            
                                <button id="downloadPDF" class="btn downloadpdf me-2">
                                    <i class="fas fa-file-pdf"></i> Download PDF
                                </button>
                            
                                <button id="download-csv" class="btn downloadcsv">
                                    <i class="fas fa-file-csv"></i> Download CSV
                                </button>
                            </div>
                            
                        </div>
                        <div class="card-body">
                            <form method="GET" id="filter-form">
                                <div class="row mb-4">
                                    <div class="col-md-3">
                                        <label for="from_date">From Date:</label>
                                        <input type="date" id="from_date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="to_date">To Date:</label>
                                        <input type="date" id="to_date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                                    </div>
                                     
                                        <div class="col-md-2 p-1 mt-3">
                                            <button type="submit" id="filter-btn" class="btn btnstyle">Search</button>
                                        </div>
                                     
                                    </div>
                                </div>
                            </form>
                             <div class=" table-responsive">
                                {!! $dataTable->table(['class' => 'table custom-datatable', 'id' => 'file-table'], true) !!}
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="statusUpdateForm" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="statusModalLabel">Update Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="File_ID" id="modalFileId">
                        <div class="mb-3">
                            <label for="newStatus" class="form-label">Select New Status</label>
                            <select name="status" id="newStatus" class="form-control">
                                <option value="L">Live</option>
                                <option value="C">Close</option>
                                <option value="A">Abortive</option>
                                <option value="I">Close Abortive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Status</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
   <!-- Modal Structure -->
   <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statusModalLabel">View File Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="File_ID" id="modalFileId">
                    <div class="from-group col-lg-12 d-flex">
                   
                    <div class="mb-3 col-6">
                        <label for="fileDate" class="form-label">File Date</label>
                        <input style="width:95%" type="text" id="fileDate" class="form-control" readonly>
                    </div>
                    <div class="mb-3 col-6 ">
                        <label for="ledgerRef" class="form-label">Ledger Reference</label>
                        <input style="width:95%" type="text" id="ledgerRef" class="form-control" readonly>
                    </div>
                </div>
                <div class="from-group col-lg-12 d-flex">

                     <div class="mb-3 col-6">
                        <label for="matter" class="form-label">Matter</label>
                        <input style="width:95%" type="text" id="matter" class="form-control" readonly>
                    </div>
                     <div class="mb-3 col-6">
                        <label for="firstName" class="form-label"> Name</label>
                        <input style="width:95%" type="text" id="firstName" class="form-control" readonly>
                    </div>
                </div>
                <div class="from-group col-lg-12 d-flex">

                     
                     <div class="mb-3 col-6">
                        <label for="address" class="form-label">Address</label>
                        <input style="width:95%" type="text" id="address" class="form-control" readonly>
                    </div>
               

                     <div class="mb-3 col-6">
                        <label for="postCode" class="form-label">Post Code</label>
                        <input style="width:95%" type="text" id="postCode" class="form-control" readonly>
                    </div>
                </div>
                <div class="from-group col-lg-12 d-flex">
                     <div class="mb-3 col-6">
                        <label for="feeEarner" class="form-label">Fee Earner</label>
                        <input style="width:95%" type="text" id="feeEarner" class="form-control" readonly>
                    </div>
                

                    <div class="mb-3 col-6">
                        <label for="status" class="form-label">Status</label><br>
                        <button type="button" id="status" class="btn"></button>
                    </div>
                </div>
            </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
        
    </div>
</div>


@endsection

@section('scripts')
    {!! $dataTable->scripts() !!}
  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    
 <script>
    $(document).ready(function () {
    $('#file-table tbody').on('click', 'tr', function () {
        let fileId = $(this).attr('id'); 
        if (!$(event.target).closest('.status-modal-trigger').length) {
            window.location.href = '/file/update/' + fileId; 
        }
    });
});


    $(document).on('click', '.view-modal-trigger', function () {
    const fileId = $(this).data('id');
    const updateUrl = '{{ route("files.get.filedata") }}';
    const formData = {
        _token: '{{ csrf_token() }}',
        id: fileId,
    };

    $.ajax({
        url: updateUrl,
        method: 'POST',
        data: formData,
        success: function (response) {
            if (response.success) {
                const fileData = response.data;

                // Populate modal fields with data from the response
                $('#modalFileId').val(fileData.File_ID);
                $('#fileID').val(fileData.File_ID);
                $('#fileDate').val(fileData.File_Date);
                $('#ledgerRef').val(fileData.Ledger_Ref);
                $('#matter').val(fileData.Matter);
                $('#firstName').val(fileData.First_Name + ' ' + fileData.Last_Name);
                $('#address').val(fileData.Address1);
                $('#postCode').val(fileData.Post_Code);
                $('#feeEarner').val(fileData.Fee_Earner);
                var status = fileData.Status;
                var statusText = "";
                var statusClass = "";

                // Determine status text and class
                if (status === 'L') {
                    statusText = "Live";
                    statusClass = "btn-success";
                } else if (status === 'C') {
                    statusText = "Close";
                    statusClass = "btn-secondary";
                } else if (status === 'A') {
                    statusText = "Abortive";
                    statusClass = "btn-danger";
                } else if (status === 'I') {
                    statusText = "Close Abortive";
                    statusClass = "btn-warning";
                } else {
                    statusText = "Unknown Status";
                    statusClass = "btn-dark";
                }

        $('#status').text(statusText).removeClass().addClass('btn ' + statusClass);

                        // Programmatically show the modal
                        $('#viewModal').modal('show');
                    } else {
                        alert('Failed to fetch file data');
                    }
                },
                error: function (xhr, status, error) {
                    console.error(error);
                    alert('An error occurred while fetching the file data');
                }
            });
        });

const initializeDataTable = () => {
        // Destroy the DataTable instance if it exists
        if ($.fn.DataTable.isDataTable('#file-table')) {
            $('#file-table').DataTable().destroy();
        }

        // Initialize the DataTable
        $('#file-table').DataTable({
            serverSide: true,
            processing: true,
            ajax: '{{ route("files.index") }}',
            responsive: true,
            columns: [
                { data: 'File_Date', title: 'Date' },
                { data: 'Ledger_Ref', title: 'Ledger Ref' },
                { data: 'Matter', title: 'Matter' },
                { data: 'First_Name', title: 'First Name' },
                { data: 'Last_Name', title: 'Last Name' },
                { data: 'Address1', title: 'Address' },
                { data: 'Post_Code', title: 'Post Code' },
                { data: 'Fee_Earner', title: 'Fee Earner' },
                { data: 'Status', title: 'Status' },
                { data: 'action', title: '', orderable: false, searchable: false },
                ],
        });
    };


$(document).on('click', '.status-modal-trigger', function () {
    const fileId = $(this).data('id');
    const currentStatus = $(this).data('status');
    
    $('#modalFileId').val(fileId);
    $('#newStatus').val(currentStatus);
    });
    $('#statusUpdateForm').on('submit', function (e) {
    e.preventDefault();
    
    const formData = $(this).serialize();
    const updateUrl = '{{ route("files.update.status") }}';
    
    $.ajax({
        url: updateUrl,
        method: 'POST',
        data: formData,
        success: function (response) {
            if (response.success) {
                Swal.fire({
                    title: 'Updated!',
                    text: 'Status updated successfully!',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                });
                $("#statusModal").hide();
                $(".modal-backdrop").hide();
                
                $('#file-table').DataTable().ajax.reload(null, false); // Prevent pagination reset

               
                
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: 'Status could not be updated.',
                    icon: 'error',
                    timer: 2000,
                    showConfirmButton: false
                });
    
                setTimeout(function () {
                    location.reload(); // Reload the page after 2 seconds
                }, 2000);
            }
        },
        error: function () {
            Swal.fire({
                title: 'Error!',
                text: 'An error occurred. Please try again later.',
                icon: 'error',
                timer: 2000,
                showConfirmButton: false
            });
        }
    });
    });

  



    $(document).on('click', '.delete-button', function (e) {
    e.preventDefault();
    
    const button = $(this);
    const fileId = button.data('id');
    const url = '{{ route("files.destroy") }}';
    
    Swal.fire({
        title: 'Are you sure?',
        text: "This action cannot be undone!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    id: fileId,
                    _token: $('meta[name="csrf-token"]').attr('content') // Pass CSRF token here
                },
                success: function (response) {
                    Swal.fire({
                        title: 'Deleted!',
                        text: 'The record has been deleted successfully.',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    });
    
                    $('#file-table').DataTable().ajax.reload(null, false); // Prevent pagination reset
                },
                error: function () {
                    Swal.fire({
                        title: 'Error!',
                        text: 'An unexpected error occurred. Please try again later.',
                        icon: 'error',
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            });
        }
    });
    });
    $(document).ready(function () {
    $('#downloadPDF').click(function () {
        var from_date = $('#from_date').val();
        var to_date = $('#to_date').val();
        var data = {}; // Empty object to avoid sending unnecessary empty values

        if (from_date && to_date) {  // Only add dates if both are set
            data.from_date = from_date;
            data.to_date = to_date;
        }

        $.ajax({
            url: "{{ route('files.download.pdf') }}",
            type: "GET",
            data: data,  // Send only if dates are set
            xhrFields: { responseType: 'blob' },
            success: function (data) {
                var blob = new Blob([data], { type: 'application/pdf' });
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = "file_report.pdf";
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            },
            error: function (xhr) {
                alert('Failed to download PDF');
            }
        });
    });
});


//     $(document).ready(function () {
//     $("#downloadPDF").click(function (event) {
//         event.preventDefault(); // Prevent form submission
//         generatePDF();
//     });

//     function generatePDF() {
//         const { jsPDF } = window.jspdf;
//         const doc = new jsPDF('p', 'mm', 'a4');

//         // **Add Title at the Top (Centered)**
//         doc.setFont("helvetica", "bold");
//         doc.setFontSize(16);
//         doc.text("File Opening Book", 105, 15, { align: "center" });

//         let pdfElement = document.getElementById('file-table');

//         if (!pdfElement || pdfElement.offsetWidth === 0 || pdfElement.offsetHeight === 0) {
//             alert("The section is hidden or empty! Ensure it has content.");
//             return;
//         }

//         let dataTable = $("#file-table").DataTable();
//         dataTable.page.len(-1).draw(); // Show all records (Remove Pagination)

//         // **Hide "Action" and "Status" Columns Temporarily**
//         $("#file-table th:last-child, #file-table td:last-child").hide(); // Hide Action column
//         $("#file-table th:nth-child(8), #file-table td:nth-child(8)").hide(); // Hide Status column

//         setTimeout(() => {
//             html2canvas(pdfElement, {
//                 scale: 2, 
//                 useCORS: true, // Fix missing styles
//                 allowTaint: true
//             }).then(canvas => {
//                 let imgData = canvas.toDataURL('image/png');
//                 let imgWidth = 210; // A4 width in mm
//                 let imgHeight = (canvas.height * imgWidth) / canvas.width;

//                 doc.addImage(imgData, 'PNG', 0, 25, imgWidth, imgHeight);
//                 doc.save('file_opening_book.pdf');

//                 dataTable.page.len(10).draw(); // Restore pagination after PDF generation

//                 // **Show "Action" and "Status" Columns Again**
//                 $("#file-table th:last-child, #file-table td:last-child").show(); // Show Action column
//                 $("#file-table th:nth-child(8), #file-table td:nth-child(8)").show(); // Show Status column
//             }).catch(error => {
//                 console.error("Error capturing PDF:", error);
//             });
//         }, 500); // Small delay to allow table rendering
//     }
// });

</script>
<script>
    $(document).ready(function () {
        const table = $('.dataTable').DataTable();
        const filterBtn = $('#filter-btn');

        $('#filter-form').on('submit', function (e) {
            e.preventDefault();

            const fromDate = $('#from_date').val();
            const toDate = $('#to_date').val();
           

            filterBtn.prop('disabled', true);

            const params = new URLSearchParams({
                from_date: fromDate || '',
                to_date: toDate || ''
               
            });

            table.ajax.url(`?${params.toString()}`).load(function () {
                filterBtn.prop('disabled', false);
            });
        });
    });
</script>
@endsection
 