console.log("js init");

//TODO FIX to work this datarange picker
const pickerElement = document.querySelectorAll('.wp-eats__date-filters-wrap');
pickerElement.forEach((picker)=>{
    const datepicker = new DateRangePicker(picker, {
        format: 'dd/mm/yyyy',
        weekStart: 1
    })
});

document.querySelectorAll('.wp_eats__list-from').forEach((form) => {
    let actionInput = form.querySelector('[name="action"]');
    form.querySelectorAll('.button--mark-as-paid').forEach((button)=>{
        button.addEventListener('click', (event)=>{
            event.preventDefault();
            actionInput.value = "mark-as-paid";
            form.submit();
        })
    })
})