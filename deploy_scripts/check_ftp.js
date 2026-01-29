const ftp = require("basic-ftp")

async function example() {
    const client = new ftp.Client()
    // client.ftp.verbose = true // Too much logging for agent output
    try {
        await client.access({
            host: "ftp.rosevillaheritagehomes.com",
            user: "gk@rosevillaheritagehomes.com",
            password: "5qJj4GpYV_S9!zi",
            secure: false
        })
        console.log("Connected!")
        console.log("Listing rosevilla_core to check for .env:")
        const list = await client.list("rosevilla_core")
        const envFile = list.find(f => f.name === '.env');
        if (envFile) {
            console.log("FOUND .env file! Size: " + envFile.size);
        } else {
            console.log("WARNING: .env file NOT found!");
        }
        console.log("All files in rosevilla_core:");
        console.log(list.map(f => f.name).join('\n'));
    }
    catch (err) {
        console.log("Error:", err)
    }
    client.close()
}

example()
