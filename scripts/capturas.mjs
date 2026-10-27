/**
 * Genera las capturas de pantalla del README en docs/capturas/.
 *
 * Requiere la aplicación corriendo con los datos del seeder:
 *
 *   php artisan migrate:fresh --seed
 *   npm run build && php artisan serve
 *   npm run capturas            # o BASE_URL=http://otra-url npm run capturas
 */
import { mkdir } from 'node:fs/promises';
import { chromium } from 'playwright';

const BASE_URL = process.env.BASE_URL ?? 'http://localhost:8000';
const SALIDA = new URL('../docs/capturas/', import.meta.url);
const ESCRITORIO = { width: 1280, height: 800 };
const MOVIL = { width: 390, height: 844 };

async function iniciarSesion(context, email) {
    const page = await context.newPage();
    await page.goto(`${BASE_URL}/login`);
    await page.fill('#email', email);
    await page.fill('#password', 'password');
    await Promise.all([page.waitForURL('**/dashboard'), page.click('button[type=submit]')]);

    return page;
}

async function capturar(page, nombre, { completa = false } = {}) {
    await page.waitForLoadState('networkidle');
    await page.screenshot({ path: new URL(`${nombre}.png`, SALIDA).pathname.replace(/^\/([A-Za-z]:)/, '$1'), fullPage: completa });
    console.log(`✓ ${nombre}.png`);
}

await mkdir(SALIDA, { recursive: true });
const browser = await chromium.launch();
const nuevoContexto = (viewport) => browser.newContext({ viewport, deviceScaleFactor: 2, locale: 'es-CO' });

try {
    // Visitante
    const visitante = await nuevoContexto(ESCRITORIO);
    const publica = await visitante.newPage();
    await publica.goto(BASE_URL);
    await capturar(publica, 'portada');
    await publica.goto(`${BASE_URL}/login`);
    await capturar(publica, 'login');
    await visitante.close();

    // Administrador
    const admin = await nuevoContexto(ESCRITORIO);
    const page = await iniciarSesion(admin, 'demo@example.com');
    await capturar(page, 'dashboard');

    await page.goto(`${BASE_URL}/municipios`);
    // Página completa para que se vea la paginación al final del listado.
    await capturar(page, 'listado', { completa: true });

    // Busca municipios por el nombre de su departamento.
    await page.goto(`${BASE_URL}/municipios?q=valle`);
    await capturar(page, 'busqueda');

    await page.goto(`${BASE_URL}/paises/create`);
    await page.fill('#pais_codi', 'COL');
    await page.fill('#pais_nomb', '');
    await page.evaluate(() => document.querySelectorAll('[required]').forEach((el) => el.removeAttribute('required')));
    await Promise.all([page.waitForLoadState('load'), page.click('button[type=submit]')]);
    await capturar(page, 'validacion');

    await page.goto(`${BASE_URL}/paises`);
    page.once('dialog', (dialog) => dialog.accept());
    await Promise.all([
        page.waitForLoadState('load'),
        page.locator('tr', { hasText: 'Colombia' }).getByRole('button', { name: 'Eliminar' }).click(),
    ]);
    await capturar(page, 'borrado-bloqueado');
    await admin.close();

    // Lector
    const lector = await nuevoContexto(ESCRITORIO);
    const paginaLector = await iniciarSesion(lector, 'lector@example.com');
    await paginaLector.goto(`${BASE_URL}/departamentos`);
    await capturar(paginaLector, 'lector');
    await lector.close();

    // Móvil
    const movil = await nuevoContexto(MOVIL);
    const paginaMovil = await iniciarSesion(movil, 'demo@example.com');
    await capturar(paginaMovil, 'movil', { completa: true });
    await movil.close();
} finally {
    await browser.close();
}
