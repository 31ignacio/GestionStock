<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}

    <title>GESTION</title>

   <!-- Google Font: Source Sans Pro -->
   <link rel="stylesheet"
   href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<link rel="stylesheet" href="../../../../AD/plugins/fontawesome-free/css/all.min.css">
<!-- DataTables -->
<link rel="stylesheet" href="../../../../AD/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="../../../../AD/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="../../../../AD/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="../../../../AD/dist/css/adminlte.min.css">

<!-- Tempusdominus Bootstrap 4 -->
<link rel="stylesheet" href="../../../../AD/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">

<!-- Bootstrap4 Duallistbox -->
<link rel="stylesheet" href="../../../../AD/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
<!-- BS Stepper -->
<link rel="stylesheet" href="../../../../AD/plugins/bs-stepper/css/bs-stepper.min.css">
<!-- dropzonejs -->
<link rel="stylesheet" href="../../../../AD/plugins/dropzone/min/dropzone.min.css">
<!-- Theme style -->


<!-- Select2 -->
<link rel="stylesheet" href="../../../../AD/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="../../../../AD/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<link rel="stylesheet" href="../../../../AD/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<link rel="stylesheet" href="../../../../AD/plugins/toastr/toastr.min.css">
{{-- <link href="https://unpkg.com/toastify-js/src/toastify.css" rel="stylesheet"> --}}
<link rel="stylesheet" href="../../../../AD/toastify-js-master/src/toastify.css">

<style>
   body {
       background-image: url('../../../../AD/dist/img/2.jpg');
       background-size: cover; /* Ajuste la taille de l'image pour couvrir tout l'écran */
       background-repeat: no-repeat; /* Empêche la répétition de l'image */
       height: 100vh; /* Assure que la hauteur de la page est égale à la hauteur de l'écran */
       margin: 0; /* Supprime la marge par défaut du corps du navigateur */
   }

   /* Ajoutez ici le reste de votre CSS ou du contenu HTML */
</style>


</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{route("accueil.index")}}" class="nav-link">Accueil</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{route('client.dette')}}" class="nav-link">Dettes clients</a>
                </li>

                
            </ul>


            
            
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ route('accueil.index') }}" class="brand-link">
                
                <h1 class="text-center font-weight-light">LEONI'S</h1>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="../../../../AD/dist/img/avatar3.png" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="{{route('admin')}}" class="d-block">Administrateur</a>
                        
                    </div>
                </div>

                <!-- SidebarSearch Form -->
                <div class="form-inline" hidden>
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="hidden" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
                            with font-awesome or any other icon font library -->

                        <li class="nav-item">
                            <a href="{{route('accueil.index')}}" class="nav-link">
                                <i class="nav-icon fas fa-home"></i>
                                <p>
                                    Accueil
                                </p>
                            </a>
                        </li>

                        @auth
                        @if(auth()->user()->role_id == 1)
                           {{-- Utilisateurs --}}

                           <li class="nav-item">
                               <a href="{{route('admin')}}" class="nav-link">
                                   <i class="fas fa-user"></i>
                                   <p>
                                       Utilisateurs
                                   </p>
                               </a>
                           </li>

                     @endif
                     @endauth


                            {{-- Client --}}
                            <li class="nav-item">
                                <a href="{{route('client.index')}}" class="nav-link">
                                    <i class="fas fa-user-friends"></i>
                                    <p>
                                        Clients
                                    </p>
                                </a>
                            </li>
                            {{-- Produit --}}
                            <li class="nav-item">
                                <a href="{{route('produit.index')}}" class="nav-link">
                                    <i class="fas fa-shopping-bag"></i>
                                    <p>
                                        Produits
                                    </p>
                                </a>
                            </li>
                            {{-- Facture --}}
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-file-invoice-dollar"></i>

                                    <p>
                                        Factures
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('facture.index') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Liste des factures</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('facture.create') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Ajouter une facture</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            {{-- Stock --}}
                         
                        <li class="nav-item">
                            <a href="{{route('stock.index')}}" class="nav-link">
                                <i class="fas fa-warehouse"></i>
                                <p>
                                    Gestion de stocks
                                </p>
                            </a>
                        </li>

                                {{-- inventaires --}}

                                <li class="nav-item">
                                    <a href="{{route('inventaires.index')}}" class="nav-link">
                                        <i class="fas fa-list"></i>
                                        <p>
                                            Inventaires
                                        </p>
                                    </a>
                                </li>
                                
                            {{-- Etat --}}
                        <li class="nav-item">
                            <a href="{{route('etat.index')}}" class="nav-link">
                                <i class="fas fa-shopping-cart"></i>

                                <p>
                                    Etats des ventes
                                    {{-- <span class="right badge badge-danger">New</span> --}}
                                </p>
                            </a>
                        </li>
                            {{--  --}}<br><br><br>
                        <li class="nav-item">
                            <a href="{{route('logout')}}" class="nav-link">
                                <i class="fas fa-sign-out-alt"></i>

                                <p>
                                    Me déconnecter
                                    <span class="right badge badge-danger">off</span>
                                </p>
                            </a>
                        </li>


                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper mt-0">
           
            
            @yield('content')

            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 1.0.6
            </div>
            <strong>Copyright &copy; 2025 <a href="">ARI </a>Expertiz</strong>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
  {{-- Dans votre vue --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>

  <!-- <script src="{{ asset('js/logout.js') }}"></script> -->

    <script src="../../../../AD/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../../../AD/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="../../../../AD/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../../../AD/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../../../../AD/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../../../AD/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="../../../../AD/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../../../../AD/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="../../../../AD/plugins/jszip/jszip.min.js"></script>
    <script src="../../../../AD/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="../../../../AD/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="../../../../AD/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="../../../../AD/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="../../../../AD/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../../../AD/dist/js/adminlte.min.js"></script>
    <script src="../../../../AD/dist/js/html2pdf.bundle.min.js"></script>

    <!-- AdminLTE for demo purposes -->
    <script src="../../../../AD/dist/js/demo.js"></script>
    <script src="../../../../AD/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="../../../../AD/plugins/toastr/toastr.min.js"></script>
    <!-- Select2 -->
        <script src="../../../../AD/plugins/select2/js/select2.full.min.js"></script>
    <!-- Bootstrap4 Duallistbox -->
    <!-- InputMask -->
    <!-- Page specific script -->
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["excel", "pdf", "print"],
                "language": {
                    "sProcessing":     "Traitement en cours...",
                    "sSearch":         "Rechercher :",
                    "sLengthMenu":     "Afficher _MENU_ éléments",
                    "sInfo":           "Affichage de l'élément _START_ à _END_ sur _TOTAL_ éléments",
                    "sInfoEmpty":      "Affichage de l'élément 0 à 0 sur 0 élément",
                    "sInfoFiltered":   "(filtré à partir de _MAX_ éléments au total)",
                    "sInfoPostFix":    "",
                    "sLoadingRecords": "Chargement en cours...",
                    "sZeroRecords":    "Aucun élément à afficher",
                    "sEmptyTable":     "Aucune donnée disponible dans le tableau",
                    "oPaginate": {
                        "sFirst":      "Premier",
                        "sPrevious":   "Précédent",
                        "sNext":       "Suivant",
                        "sLast":       "Dernier"
                    },
                    "oAria": {
                        "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
                        "sSortDescending": ": activer pour trier la colonne par ordre décroissant"
                    }
                }
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

            $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
                   "order": [[1, 'desc']],  // Trier la deuxième colonne (index 1) qui est la date
        "columnDefs": [
            {
                "targets": 1,  // Index de la colonne de date
                "orderDataType": "dom-text",  // Utilisation de "dom-text" pour trier les données
                "render": function(data, type, row) {
                    // Utiliser l'attribut data-date pour le tri
                    return row[1];  // retourne la date dans le format d'affichage
                }
            }
        ],
            "responsive": true,
            "language": {
                "sProcessing":     "Traitement en cours...",
                "sSearch":         "Rechercher :",
                "sLengthMenu":     "Afficher _MENU_ éléments",
                "sInfo":           "Affichage de l'élément _START_ à _END_ sur _TOTAL_ éléments",
                "sInfoEmpty":      "Affichage de l'élément 0 à 0 sur 0 élément",
                "sInfoFiltered":   "(filtré à partir de _MAX_ éléments au total)",
                "sInfoPostFix":    "",
                "sLoadingRecords": "Chargement en cours...",
                "sZeroRecords":    "Aucun élément à afficher",
                "sEmptyTable":     "Aucune donnée disponible dans le tableau",
                "oPaginate": {
                    "sFirst":      "Premier",
                    "sPrevious":   "Précédent",
                    "sNext":       "Suivant",
                    "sLast":       "Dernier"
                },
                "oAria": {
                    "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
                    "sSortDescending": ": activer pour trier la colonne par ordre décroissant"
                }
            }
        });
    
        });
    </script>
    

    <!-- Page specific script -->
    <script>
        $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

        //Datemask dd/mm/yyyy
        $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
        //Datemask2 mm/dd/yyyy
        $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
        //Money Euro
        $('[data-mask]').inputmask()

        //Date picker
        $('#reservationdate').datetimepicker({
            format: 'L'
        });

        //Date and time picker
        $('#reservationdatetime').datetimepicker({ icons: { time: 'far fa-clock' } });

        //Date range picker
        $('#reservation').daterangepicker()
        //Date range picker with time picker
        $('#reservationtime').daterangepicker({
            timePicker: true,
            timePickerIncrement: 30,
            locale: {
            format: 'MM/DD/YYYY hh:mm A'
            }
        })
        //Date range as a button
        $('#daterange-btn').daterangepicker(
            {
            ranges   : {
                'Today'       : [moment(), moment()],
                'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month'  : [moment().startOf('month'), moment().endOf('month')],
                'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            startDate: moment().subtract(29, 'days'),
            endDate  : moment()
            },
            function (start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
            }
        )

        //Timepicker
        $('#timepicker').datetimepicker({
            format: 'LT'
        })

        //Bootstrap Duallistbox
        $('.duallistbox').bootstrapDualListbox()

        //Colorpicker
        $('.my-colorpicker1').colorpicker()
        //color picker with addon
        $('.my-colorpicker2').colorpicker()

        $('.my-colorpicker2').on('colorpickerChange', function(event) {
            $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
        })

        $("input[data-bootstrap-switch]").each(function(){
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        })

        })
        // BS-Stepper Init
        document.addEventListener('DOMContentLoaded', function () {
        window.stepper = new Stepper(document.querySelector('.bs-stepper'))
        })

        // DropzoneJS Demo Code Start
        // Dropzone.autoDiscover = false

            // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
            var previewNode = document.querySelector("#template")
        // previewNode.id = ""
        var previewTemplate = previewNode.parentNode.innerHTML
        previewNode.parentNode.removeChild(previewNode)

        var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
        url: "/target-url", // Set the url
        thumbnailWidth: 80,
        thumbnailHeight: 80,
        parallelUploads: 20,
        previewTemplate: previewTemplate,
        autoQueue: false, // Make sure the files aren't queued until manually added
        previewsContainer: "#previews", // Define the container to display the previews
        clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
        })

        myDropzone.on("addedfile", function(file) {
        // Hookup the start button
        file.previewElement.querySelector(".start").onclick = function() { myDropzone.enqueueFile(file) }
        })

        // Update the total progress bar
        myDropzone.on("totaluploadprogress", function(progress) {
        document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
        })

        myDropzone.on("sending", function(file) {
        // Show the total progress bar when upload starts
        document.querySelector("#total-progress").style.opacity = "1"
        // And disable the start button
        file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
        })

        // Hide the total progress bar when nothing's uploading anymore
        myDropzone.on("queuecomplete", function(progress) {
        document.querySelector("#total-progress").style.opacity = "0"
        })

        // Setup the buttons for all transfers
        // The "add files" button doesn't need to be setup because the config
        // `clickable` has already been specified.
        document.querySelector("#actions .start").onclick = function() {
        myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
        }
        document.querySelector("#actions .cancel").onclick = function() {
        myDropzone.removeAllFiles(true)
        }
        // DropzoneJS Demo Code End
    </script>


    @if (Session::has('success_message') || Session::has('error_message'))
    <script>
        $(function() {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true, // Affiche une barre de progression
                customClass: {
                    popup: 'shadow-lg rounded-pill', // Styles personnalisés
                },
                didOpen: (toast) => {
                    toast.style.padding = '20px'; // Espacement supplémentaire
                }
            });

            // Détermine le type d'alerte (success ou error)
            Toast.fire({
                icon: "{{ Session::has('success_message') ? 'success' : 'error' }}",
                title: "<strong style='font-size: 16px;'>{{ Session::get('success_message') ?? Session::get('error_message') }}</strong>", // Texte amélioré
                background: '#f9f9f9', // Couleur de fond plus douce
                color: '#333', // Couleur du texte
            });
        });
    </script>
    @endif

</body>

</html>
