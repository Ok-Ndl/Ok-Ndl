document.addEventListener('DOMContentLoaded', () => {
  const printBtn = document.getElementById('printReport');
  const pdfBtn = document.getElementById('downloadPdf');

  if (printBtn) printBtn.addEventListener('click', () => window.print());

  if (pdfBtn) pdfBtn.addEventListener('click', () => {
    alert('PDF export is ready for integration with jsPDF in your browser environment.');
  });
});
