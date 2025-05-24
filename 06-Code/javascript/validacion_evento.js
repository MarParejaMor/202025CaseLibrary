function toggleEndDate() {
  const checkbox = document.getElementById('noEndDate');
  const dateEndInput = document.getElementById('dateEnd');
  if (checkbox.checked) {
    dateEndInput.value = '';
    dateEndInput.disabled = true;
  } else {
    dateEndInput.disabled = false;
  }
}

document
  .getElementById('eventForm')
  .addEventListener('submit', function (event) {
    const start = new Date(document.getElementById('dateStart').value);
    const end = new Date(document.getElementById('dateEnd').value);
    const noEndDate = document.getElementById('noEndDate').checked;

    if (!noEndDate && start > end) {
      alert('La fecha de fin no puede ser anterior a la fecha de inicio.');
      event.preventDefault();
    }
  });
