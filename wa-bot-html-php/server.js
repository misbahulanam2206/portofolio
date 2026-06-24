const { default: makeWASocket, useMultiFileAuthState, DisconnectReason } = require('@whiskeysockets/baileys');
const qrcode = require('qrcode-terminal');
const express = require('express');
const cors = require('cors');
const path = require('path');

const app = express();
const PORT = 3000;

app.use(cors());
app.use(express.json());
app.use(express.static(__dirname));

let sock; // Variabel buat nyimpen koneksi WhatsApp

// Fungsi buat nyalain Bot WhatsApp
async function connectToWhatsApp() {
    // Menyimpan sesi login di folder 'auth_info', biar ga usah scan QR bolak-balik
    const { state, saveCreds } = await useMultiFileAuthState('auth_info');

    sock = makeWASocket({
        auth: state,
        printQRInTerminal: false // Kita handle manual biar rapi
    });

    sock.ev.on('creds.update', saveCreds);

    // 1. Munculin QR Code di Terminal kalau belum login
    sock.ev.on('connection.update', (update) => {
        const { connection, lastDisconnect, qr } = update;
        if (qr) {
            console.log('\n=== SILAKAN SCAN QR INI DENGAN WHATSAPP HP KAMU ===');
            qrcode.generate(qr, { small: true });
        }
        if (connection === 'close') {
            const shouldReconnect = lastDisconnect.error?.output?.statusCode !== DisconnectReason.loggedOut;
            console.log('Koneksi terputus, mencoba menghubungkan kembali...', shouldReconnect);
            if (shouldReconnect) connectToWhatsApp();
        } else if (connection === 'open') {
            console.log('\n✅ BOT WHATSAPP BERHASIL TERHUBUNG!');
        }
    });

    // 2. Fitur Auto-Reply kalau ada orang chat ke WA kamu (Fitur Bot AI)
    sock.ev.on('messages.upsert', async (m) => {
        const msg = m.messages[0];
        if (!msg.message || msg.key.fromMe) return; // Mengabaikan pesan dari diri sendiri

        const remoteJid = msg.key.remoteJid;
        const pesanMasuk = msg.message.conversation || msg.message.extendedTextMessage?.text || '';

        console.log(`Pesan masuk dari WA (${remoteJid}): ${pesanMasuk}`);

        if (pesanMasuk) {
            // --- TEMPAT LOGIC AI KAMU (Misal panggil Gemini/OpenAI) ---
            let balasanAI = `[Bot AI]: Halo, terima kasih sudah menghubungi. Anda tadi mengetik: "${pesanMasuk}"`;
            
            if (pesanMasuk.toLowerCase().includes('halo')) {
                balasanAI = 'Halo! Ada yang bisa Bot AI bantu?';
            }

            // Kirim pesan balasan beneran ke WhatsApp pengirim
            await sock.sendMessage(remoteJid, { text: balasanAI });
        }
    });
}

// 3. Endpoint Dashboard Web (Biar bisa kirim pesan lewat Web)
app.get('/', (req, res) => {
    res.sendFile(path.join(__dirname, 'index.html'));
});

app.post('/api/chat', async (req, res) => {
    const { pesan } = req.body;
    
    if (!sock) {
        return res.status(500).json({ balasan: 'Bot WA belum siap / terhubung.' });
    }

    try {
        // Balasan simulasi untuk di dashboard web kamu
        let balasanBot = `[Bot AI]: Memproses pesan "${pesan}" via Web.`;

        // CONTOH EXTRA: Kalau mau sekalian ngirim pesan broadcast ke nomor tertentu dari web, pakainya:
        // await sock.sendMessage('628xxxxxxxxxx@s.whatsapp.net', { text: pesan });

        res.json({ balasan: balasanBot });
    } catch (error) {
        res.status(500).json({ balasan: 'Gagal memproses pesan di web.' });
    }
});

// Jalankan semuanya
app.listen(PORT, () => {
    console.log(`🚀 Dashboard ready di http://localhost:${PORT}`);
    connectToWhatsApp(); // Jalankan bot WA
});