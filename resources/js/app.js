import './bootstrap';

const endpoints = {
    token: {
        title: 'Obtener token',
        method: 'POST',
        url: '/api/factus/token',
        fields: [],
    },
    ranges: {
        title: 'Consultar rangos',
        method: 'GET',
        url: '/api/factus/numbering-ranges',
        fields: [
            ['id', 'ID'],
            ['document', 'Documento'],
            ['resolution_number', 'Resolucion'],
            ['technical_key', 'Clave tecnica'],
            ['is_active', 'Activo'],
        ],
    },
    bills: {
        title: 'Consultar facturas',
        method: 'GET',
        url: '/api/factus/bills',
        fields: [
            ['identification', 'Identificacion'],
            ['names', 'Nombres'],
            ['number', 'Numero'],
            ['prefix', 'Prefijo'],
            ['reference_code', 'Codigo referencia'],
            ['status', 'Estado'],
        ],
    },
    billNumber: {
        title: 'Buscar factura por numero',
        method: 'GET',
        url: '/api/factus/bills',
        fields: [
            ['number', 'Numero de factura'],
            ['prefix', 'Prefijo'],
        ],
    },
    billCustomer: {
        title: 'Buscar facturas por cliente',
        method: 'GET',
        url: '/api/factus/bills',
        fields: [
            ['identification', 'Identificacion'],
            ['names', 'Nombres'],
        ],
    },
    validate: {
        title: 'Crear factura',
        method: 'POST',
        url: '/api/factus/bills/validate',
        fields: [],
        help: 'Primero consulta rangos para guardar la numeracion en cache. Luego ajusta el JSON con los datos mínimos de la factura.',
        showPayload: true,
        payloadDefault: JSON.stringify({
            reference_code: 'FAC-2026-0001',
            document: '01',
            operation_type: '10',
            observation: 'Factura generada desde el panel',
            payment_details: [
                {
                    payment_form: '1',
                    payment_method_code: '10',
                    reference_code: 'PAGO-001',
                    amount: 11900,
                },
            ],
            establishment: {
                name: 'MI EMPRESA SAS',
                address: 'Calle 1 # 1-1',
                municipality_code: '11001',
                phone_number: '3000000000',
                email: 'facturacion@miempresa.com',
            },
            customer: {
                identification_document_code: '31',
                identification: '123456789',
                legal_organization_code: '1',
                tribute_code: 'ZZ',
                names: 'Cliente Ejemplo',
                company: 'Cliente Ejemplo SAS',
                address: 'Calle Cliente 123',
                email: 'cliente@ejemplo.com',
                phone: '3001112233',
            },
            items: [
                {
                    code_reference: 'PROD-001',
                    name: 'Producto de prueba',
                    quantity: 1,
                    discount_rate: 0,
                    price: 10000,
                    unit_measure_code: '94',
                    standard_code: '999',
                    taxes: [
                        {
                            code: '01',
                            rate: 19.0,
                        },
                    ],
                },
            ],
        }, null, 2),
    },
    billShow: {
        title: 'Ver factura por numero',
        method: 'GET',
        url: '/api/factus/bills/{number}',
        fields: [
            ['number', 'Numero completo'],
        ],
    },
    creditNotes: {
        title: 'Consultar notas credito',
        method: 'GET',
        url: '/api/factus/credit-notes',
        fields: [
            ['identification', 'Identificacion'],
            ['names', 'Nombres'],
            ['number', 'Numero'],
            ['prefix', 'Prefijo'],
            ['reference_code', 'Codigo referencia'],
            ['status', 'Estado'],
            ['start_date', 'Fecha inicio', 'date'],
            ['end_date', 'Fecha fin', 'date'],
        ],
    },
    supportDocuments: {
        title: 'Consultar documentos soporte',
        method: 'GET',
        url: '/api/factus/support-documents',
        fields: [
            ['identification', 'Identificacion'],
            ['names', 'Nombres'],
            ['number', 'Numero'],
            ['prefix', 'Prefijo'],
            ['reference_code', 'Codigo referencia'],
            ['status', 'Estado'],
            ['start_date', 'Fecha inicio', 'date'],
            ['end_date', 'Fecha fin', 'date'],
        ],
    },
    company: {
        title: 'Consultar empresa',
        method: 'GET',
        url: '/api/factus/companies',
        fields: [],
    },
};

const form = document.querySelector('#requestForm');
const buttons = document.querySelectorAll('[data-endpoint]');
const dynamicFields = document.querySelector('#dynamicFields');
const endpointTitle = document.querySelector('#endpointTitle');
const methodBadge = document.querySelector('#methodBadge');
const statusBox = document.querySelector('#requestStatus');
const responseBox = document.querySelector('#responseBox');
const clearButton = document.querySelector('#clearResponse');
const payloadWrap = document.querySelector('#payloadWrap');
const payloadInput = document.querySelector('#payloadInput');

let currentEndpoint = 'token';

function setStatus(text, state = 'idle') {
    if (!statusBox) return;
    statusBox.textContent = text;
    statusBox.dataset.state = state;
}

function setActiveButton(activeKey) {
    buttons.forEach((button) => {
        const icon = button.querySelector('.material-symbols-sharp');
        const isActive = button.dataset.endpoint === activeKey;

        button.classList.toggle('bg-green-50', isActive);
        button.classList.toggle('text-green-700', isActive);
        button.classList.toggle('ring-1', isActive);
        button.classList.toggle('ring-green-100', isActive);
        button.classList.toggle('text-gray-700', !isActive);
        icon?.classList.toggle('text-green-600', isActive);
        icon?.classList.toggle('text-gray-400', !isActive);
    });
}

function renderEndpoint(key) {
    const endpoint = endpoints[key];
    currentEndpoint = key;

    endpointTitle.textContent = endpoint.title;
    methodBadge.textContent = endpoint.method;
    dynamicFields.innerHTML = '';

    endpoint.fields.forEach(([name, label, type = 'text', options = []]) => {
        const wrapper = document.createElement('label');
        wrapper.textContent = label;

        const input = document.createElement(type === 'select' ? 'select' : 'input');
        input.name = name;

        if (type === 'select') {
            options.forEach(([value, optionLabel]) => {
                const option = document.createElement('option');
                option.value = value;
                option.textContent = optionLabel;
                input.appendChild(option);
            });
        } else {
            input.type = type;
            input.placeholder = 'Opcional';
        }

        wrapper.appendChild(input);
        dynamicFields.appendChild(wrapper);
    });

    if (endpoint.help) {
        const help = document.createElement('p');
        help.className = 'field-help';
        help.textContent = endpoint.help;
        dynamicFields.appendChild(help);
    }

    if (endpoint.showPayload) {
        payloadWrap.classList.remove('hidden');
        payloadInput.value = endpoint.payloadDefault || '';
    } else {
        payloadWrap.classList.add('hidden');
        payloadInput.value = '';
    }

    setActiveButton(key);
}

function endpointUrl(endpoint, formData) {
    let url = endpoint.url;

    endpoint.fields.forEach(([name, , , , target = 'query']) => {
        if (target !== 'path') return;
        const value = formData.get(name);
        url = url.replace(`{${name}}`, encodeURIComponent(value || ''));
    });

    if (endpoint.method !== 'GET') {
        return url;
    }

    const params = new URLSearchParams();
    endpoint.fields.forEach(([name, , , , target = 'query']) => {
        if (target === 'path' || target === 'body') return;
        const value = formData.get(name);
        if (value) params.set(name, value);
    });

    return params.size ? `${url}?${params}` : url;
}

function requestBody(endpoint, formData) {
    if (endpoint.showPayload) {
        const payload = payloadInput.value.trim();
        if (!payload) {
            throw new Error('Debes proporcionar un payload JSON válido para esta solicitud.');
        }

        try {
            const parsed = JSON.parse(payload);
            return JSON.stringify(parsed);
        } catch (error) {
            throw new Error('Payload JSON inválido. Corrige la sintaxis antes de enviar.');
        }
    }

    const body = {};

    endpoint.fields.forEach(([name, , , , target = 'query']) => {
        if (target !== 'body') return;
        const value = formData.get(name);
        if (value) body[name] = value;
    });

    return Object.keys(body).length ? JSON.stringify(body) : undefined;
}

async function executeRequest(event) {
    event.preventDefault();

    const endpoint = endpoints[currentEndpoint];
    const formData = new FormData(form);
    let body;

    try {
        body = requestBody(endpoint, formData);
    } catch (error) {
        responseBox.textContent = JSON.stringify({ error: error.message }, null, 2);
        setStatus('Error', 'error');
        return;
    }

    setStatus('Consultando...', 'loading');
    responseBox.textContent = 'Cargando respuesta...';

    try {
        const response = await fetch(endpointUrl(endpoint, formData), {
            method: endpoint.method,
            headers: {
                Accept: 'application/json',
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: endpoint.method === 'GET' ? undefined : body,
        });

        const contentType = response.headers.get('content-type') || '';
        const data = contentType.includes('application/json')
            ? await response.json()
            : await response.text();

        responseBox.textContent = typeof data === 'string' ? data : JSON.stringify(data, null, 2);
        setStatus(response.ok ? 'Completado' : `Error ${response.status}`, response.ok ? 'success' : 'error');
    } catch (error) {
        responseBox.textContent = JSON.stringify({ error: error.message }, null, 2);
        setStatus('Error de red', 'error');
    }
}

if (form) {
    buttons.forEach((button) => {
        button.addEventListener('click', () => renderEndpoint(button.dataset.endpoint));
    });

    form.addEventListener('submit', executeRequest);
    clearButton?.addEventListener('click', () => {
        responseBox.textContent = '{}';
        setStatus('Listo');
    });

    renderEndpoint(currentEndpoint);
}
