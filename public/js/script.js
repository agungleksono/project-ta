function getCookie(name) {
	function escape(s) { return s.replace(/([.*+?\^$(){}|\[\]\/\\])/g, '\\$1'); }
	var match = document.cookie.match(RegExp('(?:^|;\\s*)' + escape(name) + '=([^;]*)'));
	return match ? match[1] : null;
}

function getData(url, token) {
	return fetch(url, {
		headers: {
			"Authorization" : `Bearer ${token}`
		}
	})
	.then(response => response.json())
	.then(json => json.data)
	.catch(error => console.error(error))
}

function getDetailData(url, token) {
	return fetch(url, {
		headers: {
			"Authorization" : `Bearer ${token}`
		}
	})
	.then(response => response.json())
	.then(json => json.data)
	.catch(error => console.log(error))
}

function deleteData(url, token) {
	return fetch(url, {
		method: 'DELETE',
		headers: {
			'Authorization' : `Bearer ${token}`
		}
	})
	.then(response => response.json())
	.then(json => {
		console.log(json)
	})
	.catch(err => console.log(err))
}

function addData(url, data, token) {
	return fetch(url, {
		method: 'POST',
		body: JSON.stringify(data),
		headers: {
			"Content-type": "application/json; charset=UTF-8",
			'Authorization' : `Bearer ${token}`,
		}
	})
	.then(response => response.json())
	.then(json => {
		console.log(json);
		if (json.meta.status == 'error') {
			return swal("Data gagal ditambahkan", {
				icon: "error",
			});
		}
		return swal({
			title: "Sukses",
			text: "Berhasil menambahkan data.",
			icon: "success",
		});
	})
	.catch(err => console.log(err))
}

function dateFormatter(data) {
	const month = ["Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des"];
	const date = new Date(data);
	return `${date.getDate()} ${month[date.getMonth()]} ${date.getFullYear()}`;
	// return `${date.getFullYear()}-${date.getMonth()}-${date.getDate()}`;
}

function dateFormatCompare(data) {
	const date = new Date(data);
	return `${date.getFullYear()}-${date.getMonth()}-${date.getDate()}`;
	// return `${date.getFullYear()}-${date.getMonth()}-${date.getDate()}`;
}