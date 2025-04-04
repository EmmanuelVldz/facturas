import { ref } from 'vue';
import Swal from 'sweetalert2';
import { sendInvoiceByEmail } from '@/services/invoiceService';
import showError from '@/utils/showError';

export const useSendInvoiceEmail = () => {

  const sendEmail = async (invoice) => {
    const { success, data, msg } = await sendInvoiceByEmail(invoice.UID);

    if (success) {
      Swal.fire({
        title: 'Enviado',
        text: data.message,
        icon: 'success',
        timer: 2200,
      });
    } else {
      showError(msg);
    }
  };

  return { sendEmail };
};
