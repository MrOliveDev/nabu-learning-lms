<script>
$(document).ready(function(){
    $("#ReportPanel").tabs({ active: 0 });

    $("#historic-table").dataTable({
        pageLength: 5,
            lengthMenu: false,
            searching: false,
            autoWidth: false,
            dom: "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-6'i><'col-sm-6'p>>",
            "columnDefs": [ {
                "targets": 5,
                "orderable": false
            } ]
    });

    jQuery.resizable('verticalSplit1', "v");
    jQuery.resizable('verticalSplit2', "v");
    jQuery.resizable('horizSplit1', "h");
    jQuery.resizable('horizSplit2', "h");
    jQuery.resizable('horizSplit3', "h");
    jQuery.resizable('horizSplit4', "h");

    $("#modelDragItems").tabs({ active: 0 });

    $("#model-trumb-pane").trumbowyg();
});
</script>