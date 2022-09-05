@if($elementType === 'input')
    if(currentElement.value) {
@else 
    if(currentElement.checked === true) {
@endif