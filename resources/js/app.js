// Js for Create Role Page In Admin Dashboard
let guardName = document.getElementById('guard_name');
if(guardName){
    document.getElementById('guard_name').addEventListener('change', function() {
        let selectedGuard = this.value;

        // hide all permission groups
        document.querySelectorAll('.permissions-group').forEach(g => g.style.display = 'none');

        if(selectedGuard) {
            document.getElementById('permissions_section').style.display = 'block';
            let target = document.querySelector(`.permissions-group[data-guard="${selectedGuard}"]`);
            if(target) target.style.display = 'block';
        } else {
            document.getElementById('permissions_section').style.display = 'none';
        }
    });
}



// Js for Edit Role Page In Admin Dashboard
document.getElementById('edit_guard_name').addEventListener('change', function () {
    let guard = this.value;

    let url = getPermissionsUrl.replace(':guard', guard);

    fetch(url)
        .then(response => response.json())
        .then(data => {
            let wrapper = document.getElementById('edit-permissions-wrapper');
            wrapper.innerHTML = '';

            data.forEach(permission => {
                let checked = rolePermissions.includes(permission.id) ? 'checked' : '';

                wrapper.innerHTML += `
                    <div class="col-md-3 mb-2">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="permissions[]" value="${permission.id}" id="edit_perm_${permission.id}" ${checked}>
                            <label class="form-check-label" for="edit_perm_${permission.id}">${permission.name}</label>
                        </div>
                    </div>
                `;
            });
        });
});

