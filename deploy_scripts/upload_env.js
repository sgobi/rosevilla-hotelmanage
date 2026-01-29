const ftp = require("basic-ftp")
const path = require("path")

async function uploadEnv() {
    const client = new ftp.Client()
    try {
        await client.access({
            host: "ftp.rosevillaheritagehomes.com",
            user: "gk@rosevillaheritagehomes.com",
            password: "5qJj4GpYV_S9!zi",
            secure: false
        })
        console.log("Connected!")
        const localEnv = path.join(__dirname, '../.env')
        console.log("Uploading .env to rosevilla_core/.env ...")

        await client.uploadFrom(localEnv, "rosevilla_core/.env")

        console.log("Upload complete!")
    }
    catch (err) {
        console.log("Error:", err)
    }
    client.close()
}

uploadEnv()
