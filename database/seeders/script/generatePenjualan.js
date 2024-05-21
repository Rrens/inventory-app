let buildingSupplies = [
    'Kran Air Amico 1/2',
    'Kran Air Sanho 1/2',
    'Selotip',
    'Pisau Potong WD',
    'Paku Beton 3 dim',
    'Sekrup Baja 3 dim',
    'Sekrup Baja 2 dim',
    'Baut Drilling 12x25cm',
    'Cat Semprot',
    'Lem Besi Dextone',
    'Meteran 5M',
    'Semen Gresik',
    'Cat Tembok EMCO',
    'Bor Besi 2MM',
];

function generateOrders(numOrders = 40, buildingSupplies) {
    const orders = [];
    for (let i = 0; i < numOrders; i++) {
        const order = {
            order_date: `2024-04-${18 + Math.floor(i / 10)}`,
            items: []
        };

        const selectedItems = new Set();
        while (selectedItems.size < buildingSupplies.length) {
            const randomIndex = Math.floor(Math.random() * buildingSupplies.length);
            const productName = buildingSupplies[randomIndex];
            if (!selectedItems.has(productName)) {
                selectedItems.add(productName);
                order.items.push({ product_name: productName, quantity: Math.floor(Math.random() * 15) + 5 });
            }
        }

        orders.push(order);
    }

    return orders;
}

const generatedOrders = generateOrders(40, buildingSupplies);
console.log(JSON.stringify(generatedOrders, null, 2));
