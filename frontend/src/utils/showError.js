import Swal from "sweetalert2";

export default function showError(msg) {
  Swal.fire({
    title: "Error",
    text: msg,
    icon: "error",
  });
}