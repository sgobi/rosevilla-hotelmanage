const ftp = require("basic-ftp")
const path = require("path")

async function deploy() {
    const client = new ftp.Client(300000) // 5 minutes timeout
    // client.ftp.verbose = true // Too verbose for output capture usually, but helpful for debugging
    try {
        await client.access({
            host: "ftp.rosevillaheritagehomes.com",
            user: "gk@rosevillaheritagehomes.com",
            password: "5qJj4GpYV_S9!zi",
            secure: false
        })
        console.log("Connected!")
        const localDir = path.join(__dirname, '../dist_upload/root')
        console.log(`Uploading contents of ${localDir} to remote root / ...`)

        // Progress tracking not easily available via simple console log in basic-ftp without verbose
        // But let's trust it works or fails
        await client.uploadFromDir(localDir, "/")

        console.log("Upload complete!")
    }
    catch (err) {
        console.log("Error:", err)
    }
    client.close()
}

deploy()
