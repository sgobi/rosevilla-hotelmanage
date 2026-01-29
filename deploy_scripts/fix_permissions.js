const ftp = require("basic-ftp")

async function fix() {
    const client = new ftp.Client()
    try {
        await client.access({
            host: "ftp.rosevillaheritagehomes.com",
            user: "gk@rosevillaheritagehomes.com",
            password: "5qJj4GpYV_S9!zi",
            secure: false
        })
        console.log("Connected!")
        console.log("Setting 775 on storage and bootstrap/cache...")

        const dirs = [
            "rosevilla_core/storage",
            "rosevilla_core/storage/logs",
            "rosevilla_core/storage/framework",
            "rosevilla_core/storage/framework/views",
            "rosevilla_core/storage/framework/sessions",
            "rosevilla_core/storage/framework/cache",
            "rosevilla_core/bootstrap/cache"
        ];

        for (const d of dirs) {
            try {
                await client.send(`SITE CHMOD 775 ${d}`)
                console.log(`chmod 775 ${d} OK`)
            } catch (e) {
                console.log(`chmod 775 ${d} Failed: ${e.message}`)
            }
        }

    }
    catch (err) {
        console.log("Error:", err)
    }
    client.close()
}

fix()
