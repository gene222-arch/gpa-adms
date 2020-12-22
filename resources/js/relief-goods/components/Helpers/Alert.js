
 /**
  * Alert
  */

 export const onSuccess = (message = 'Your work has been saved') =>
 {
    Swal.fire({
        icon: 'success',
        title: message,
        showConfirmButton: false,
        timer: 1500
      })
 };

 export const onError = (message = 'Something went wrong!') =>
 {
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: message,
      })
 };

 export const onInfo = (message = 'Informational Message') =>
 {
    Swal.fire({
        icon: 'info',
        title: 'Please read...',
        text: message,
      })
 };

 export const onDelete = (message = 'Your data has been deleted.') =>
 {
      Swal.fire(
        'Deleted!',
        message,
        'success'
      )
 }
