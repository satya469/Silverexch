// $( document ).ready(function() {
//     if(window.devtools.isOpen){
//       logout();
//     }
//     window.addEventListener('devtoolschange', event => {
//       if(event.detail.isOpen){
//         logout();
//       }
//     });
// });
function logout() {
    window.location.href = '/logout';
}
