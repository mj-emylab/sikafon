export default {
    // password showing
    showPassword(x) {
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    },

    // open modal
    openModal(modalID) {
        $(modalID).modal('show');
    },

    // hide modal
    hideModal(modalID) {
        $(modalID).modal('hide');
    },

    // error message
    errorMessage(error) {
        if (error.response.data.status == 422) {
            let keys = Object.keys(error.response.data.message);
            this.errorAlert(error.response.data.message[keys[0]][0]);
        } else {
            this.errorToastAlert(error.response.data.message);
        }
    },

    // success alert
    successAlert(message) {
        Toast.fire("Success ", message, "success");
    },

    // error alert toast
    errorToastAlert(message) {
        Toast.fire("Failed", message, "warning");
    },

    // error alert
    errorAlert(error) {
        Swal.fire("Failed ", error, "warning");
    },

    // image upload
    uploadFile(e) {
        let poster = '';
        let file = e.target.files[0];
        if (file.type === 'image/jpeg' || file.type === 'image/png' || file.type === 'image/jpg') {
            if (file.size < 10097152) {
                poster = file;
            } else {
                Swal.fire('Image Size Too Large', 'Image size cannot be more than 10MB', 'warning');
            }
        } else {
            Swal.fire('File Format not Supported', 'Supported file types are jpg | jpeg | png', 'warning');
        }

        return poster;
    },

    // preview uploaded image
    previewImage(file) {
        let showImage = [];
        let reader = new FileReader();
        reader.onload = (e) => {
            showImage.push(e.target.result);
        };
        reader.readAsDataURL(file);
        return showImage;
    },

    // File upload using component
    uploadFileUsingComponent(e) {
        let poster = '';
        let file = e;
        if (file.type === 'image/jpeg' || file.type === 'image/png' || file.type === 'image/jpg') {
            if (file.size < 2097152) {
                poster = file;
            } else {
                Swal.fire('Image Size Too Large', 'Image size cannot be more than 2MB', 'warning');
            }
        } else {
            Swal.fire('File Format not Supported', 'Supported file types are jpg | jpeg | png', 'warning');
        }

        return poster;
    },

    // Preview using component
    previewImageComponent(file) {
        let showImage = [];
        let reader = new FileReader();
        reader.onload = (e) => {
            showImage.push(e.target.result);
        };
        reader.readAsDataURL(file);
        return showImage;
    },

    // pagination
    pagination(res) {
        let pagination = {
            current_page: res.current_page,
            last_page: res.last_page,
            next_page_url: res.next_page_url,
            prev_page_url: res.prev_page_url,
            from_page: res.from,
            to_page: res.to,
            total_page: res.total
        };

        return pagination;
    },

    // filter data
    filterData(data, search) {
        let sale = data;
        if (search) {
            sale = sale.filter((row) => {
                return Object.keys(row).some((key) => {
                    return String(row[key]).toLowerCase().indexOf(search.toLowerCase()) > -1;
                });
            });
        }
        return sale;
    },

    // Generating random string
    randomString() {
        return Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);
    },

    // Deleting with sweet alert
    deletingAlert(text) {
        return Swal.fire({
            title: 'Are you sure ?',
            text: text,
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        });
    },


    // Any file uploader
    uploadFiles(e) {

        let poster = '';
        let file = e.target.files[0];

        var allowed = ["image/png", "image/jpeg", "image/jpg"];
        let is_allowed = allowed.includes(file.type);

        if (is_allowed) {
            console.log(file.type)
            if (file.size < 10097152) {
                poster = file;
            } else {
                Swal.fire('File Size Too Large', 'File size cannot be more than 10MB', 'warning');
            }
        } else {
            console.log(file.type)
            Swal.fire('File Format not Supported', 'Supported file types are ', 'warning');
        }

        return poster;
    },
    // Any file upload using component
    uploadAnyFileUsingComponent(e) {

        let poster = '';
        let file = e;

        var allowed = ["image/png", "image/jpeg", "image/jpg"];
        let is_allowed = allowed.includes(file.type);

        if (is_allowed) {
            console.log(file.type)
            if (file.size < 2097152) {
                poster = file;
            } else {
                Swal.fire('File Size Too Large', 'File size cannot be more than 2MB', 'warning');
            }
        } else {
            console.log(file.type)
            Swal.fire('File Format not Supported', 'Supported file types are ', 'warning');
        }

        return poster;
    },
}