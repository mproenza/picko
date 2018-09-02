<?php 
use Cake\I18n\I18n;
?>
<script>
    var form = $('form');
    var datepicker = form.find('.datepicker');
    
    datepicker.datepicker({
        format: "dd/mm/yyyy",
        language: '<?php echo I18n::getLocale()?>',
        startDate: '+2d',
        todayBtn: "linked",
        autoclose: true,
        todayHighlight: false
    });
    
    form.submit(function(event) {
        if (this.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        }
        this.classList.add('was-validated');
    });
    
</script>