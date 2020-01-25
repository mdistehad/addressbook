const contacts = document.getElementById('contacts');

if(contacts){
    contacts.addEventListener('click',e =>{
      if(e.target.className === 'btn btn-danger delete-contact'){
         if(confirm('Are you want to delete this?')){
             const id = e.target.getAttribute('data-id');

             fetch(`/contact/delete/${id}`,{
                 method: 'DELETE'
             }).then(res => window.location.reload());
         }
      }
    });
}