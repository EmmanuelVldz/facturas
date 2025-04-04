import { ref } from 'vue';
import Swal from 'sweetalert2';
import { cancelInvoice } from '@/services/invoiceService';
import showError from '@/utils/showError';

export const useCancelInvoice = () => {

  const cancelationReasons = [
    { value: '01', label: '01 Comprobante emitido con errores con relación' },
    { value: '02', label: '02 Comprobante emitido con errores sin relación' },
    { value: '03', label: '03 No se llevó a cabo la operación' },
    { value: '04', label: '04 Operación nominativa relacionada en la factura global' }
  ];

  const cancelCfdi = async (invoice, triggerUpdateLoading, triggerFetchInvoices) => {
    const result = await Swal.fire({
      title: `¿Cancelar la factura ${invoice.Folio}?`,
      text: 'Para cancelar la factura se debe especificar un motivo.',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Sí, cancelar',
      cancelButtonText: 'No',
      input: 'select',
      inputOptions: cancelationReasons.reduce((options, reason) => {
        options[reason.value] = reason.label;
        return options;
      }, {}),
      inputPlaceholder: 'Seleccione un motivo',
      showLoaderOnConfirm: true,
      preConfirm: (value) => {
        if (!value) {
          Swal.showValidationMessage('Debe seleccionar un motivo de cancelación');
          return false;
        }
        return value;
      },
    });

    if (result.isConfirmed) {
      triggerUpdateLoading(true);
      const { success, data, msg } = await cancelInvoice(invoice.UID, result.value);
      triggerUpdateLoading(false);
      if (success) {
        await Swal.fire({
          title: 'Éxito',
          text: data.message,
          icon: 'success',
          timer: 2200,
        });
        triggerFetchInvoices();
      } else {
        showError(msg);
      }
    }
  };

  return { cancelCfdi };
};
