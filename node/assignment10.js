const express = require("express");
const axios = require("axios");
const fs = require("fs");

const app = express();

app.get('/', (req, res) => {
    res.json({
        data: {
            greeting: "ITP-405 Assignment: 10",
        }
    });
})

app.get("/api/github/:username", (req, res) => {

    const username = req.params.username;
    const accept = "application/json";
    
    fs.readFile(`.${username}.txt`, "utf8", (error, data) => {

        if (error) {
            axios
                .get(`https://api.github.com/users/${username}`, {
                    headers: { accept },
                })
                .then((repos) => {
                    fs.writeFile(`./${username}.txt`, repos.data.public_repos.toString(), (e) => {});
                    res.json(repos.data.public_repos);
                    res.end();
                });
        }
        else {
            res.write(data);
            res.end();

        }
    })

});

app.listen(8000);
