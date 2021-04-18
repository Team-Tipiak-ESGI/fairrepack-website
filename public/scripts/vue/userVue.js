const userVue = {};

userVue.basicUserInfo = (div, id) => {
    authenticatedFetch(`/api/user/read.php?id=${id}`)
        .then(res => {
            if (res.status === 200)
                return res.json();
        })
        .then(json => {
            console.log(json);
        });
}