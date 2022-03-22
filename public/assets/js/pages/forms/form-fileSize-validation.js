Filevalidation = () => {
    const fi = document.getElementById('file');
    // Check if any file is selected.
    if (fi.files.length > 0) {
        for (const i = 0; i <= fi.files.length - 1; i++) {

            //const type = fi.files.item(i).type;
            if (!validFileType(fi.files.item(i))) {
                alert(
                    "🟥 File type Incorrect, please select a PNG, JPEG or JPG file 🙏 ");
            }

            const fsize = fi.files.item(i).size;
            const file = Math.round((fsize / 1024));
            // The size of the file.
            if (file >= 2048) {
                alert(
                    "🟥 File too Big, please select a file less than 2MB 🙏");
            } else {
                const fileSize = returnFileSize(fsize)
                document.getElementById('size').innerHTML = '(<b>' +
                    fileSize + '</b>)';
            }
        }
    }
}

var fileTypes = [
    'image/jpeg',
    'image/jpg',
    'image/png',
    'application/pdf',
]

function validFileType(file) {
    for (let i = 0; i < fileTypes.length; i++) {
        /*console.log(fileTypes[i]);
        console.log(file.type);*/
        if (file.type === fileTypes[i]) {
            return true;
        }
    }

    return false;
}

function returnFileSize(number) {
    if (number < 1024) {
        return number + ' octets';
    } else if (number >= 1024 && number < 1048576) {
        return (number / 1024).toFixed(1) + ' Ko';
    } else if (number >= 1048576) {
        return (number / 1048576).toFixed(1) + ' Mo';
    }
}