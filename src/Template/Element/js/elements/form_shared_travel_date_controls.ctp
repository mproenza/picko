<script type="text/javascript">
    
    function openForm(event) {
        bootbox.dialog({title:$(this).data('title'), message:$( '#' + $(this).data('form') ).html()});
        
        form = $('.bootbox form');
        datepicker = form.find('.datepicker');

        datepicker.datepicker({
            format: "dd/mm/yyyy",
            language: '<?php echo 'es'?>',
            //startDate: 'today',
            todayBtn: "linked",
            autoclose: true,
            todayHighlight: true
        });

        form.validate({
            wrapper: 'div',
            errorClass: 'text-danger',
            errorElement: 'div'
        });

        $('.bootbox .datepicker').datepicker({
            format: "dd/mm/yyyy",
            language: '<?php echo 'es'?>',
            //startDate: 'today',
            todayBtn: "linked",
            autoclose: true,
            todayHighlight: true
        });
        
        event.preventDefault();
    }
            

    $(document).ready(function(){
        $( ".open-form" ).click(openForm);
    });
 </script>