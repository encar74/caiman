<script setup>
import { useCurrency } from '@/Composables/currency.js';
import Badge from 'primevue/badge';
import Button from 'primevue/button';
import Column from 'primevue/column';
import DataTable from 'primevue/datatable';
import Dialog from 'primevue/dialog';
import PickList from 'primevue/picklist';
import { computed, ref } from 'vue';

const props = defineProps({
	orders: Array,
});

const { euro, percentage } = useCurrency();

const detailModal = ref(false);
const detailItem = ref(null);
const openDetail = (item) => {
	detailModal.value = true;
	detailItem.value = item;
};

const orders = ref([props.orders, []]);

const products = computed(() => {
	const orders_aux = JSON.parse(JSON.stringify(orders.value[1])).map((item) => item.order_details);
	const order_details_aux = orders_aux.flat();
	const products = order_details_aux.reduce((prev, cur) => {
		let product = {
			product_id: cur.product_id,
			product_name: cur.product_name,
			product_quantity: cur.product_quantity,
			stock_quantity: cur.stock_available.quantity,
		};

		let prodIndex = prev.findIndex((item) => item.product_id === product.product_id);
		if (prodIndex !== -1) prev[prodIndex].product_quantity += cur.product_quantity;
		else prev.push(product);
		return prev;
	}, []);
	return products;
});
</script>

<template>
	<div class="grid grid-cols-6 gap-5 dark:planner">
		<Dialog
			v-if="detailItem"
			v-model:visible="detailModal"
			:breakpoints="{ '960px': '75vw', '640px': '90vw' }"
			:style="{ width: '40vw' }"
			class="select-none ring ring-gray-200 cursor-move"
		>
			<template #header>
				<p class="text-xl font-bold mr-10">Pedido {{ detailItem.reference }}</p>
			</template>
			<div class="flex flex-col gap-2">
				<p><b>Cliente:</b> {{ detailItem.customer_fullname }}</p>
				<p><b>Fecha:</b> {{ detailItem.date_add }}</p>
				<DataTable :value="detailItem.order_details" responsiveLayout="stack" breakpoint="960px" stripedRows>
					<template #header>Líneas de pedido</template>
					<Column field="product_name" header="Producto" :sortable="true" class="!text-right !md:text-left" />
					<Column field="product_quantity" header="Cantidad" class="!text-center" />
					<Column field="product_price" header="Precio unitario" class="!text-center">
						<template #body="{ data }">{{ euro(data.product_price) }}</template>
					</Column>
					<Column field="tax_rate" header="Impuestos">
						<template #body="{ data }">{{ percentage(data.tax_rate / 100) }}</template>
					</Column>
					<Column field="total_price_tax_incl" header="Total" class="!text-center">
						<template #body="{ data }">{{ euro(data.total_price_tax_incl) }}</template>
					</Column>
				</DataTable>
			</div>
		</Dialog>

		<div class="col-span-full 2xl:col-span-4">
			<PickList v-model="orders" listStyle="height:350px" dataKey="reference" :showSourceControls="false" :showTargetControls="false" breakpoint="1080px">
				<template #sourceheader>Pedidos</template>
				<template #targetheader>Preparados</template>
				<template #item="{ item }">
					<div class="grid grid-cols-[1fr,1fr,min-content] items-center gap-4 text-center md:text-left select-none">
						<div class="col-span-full md:col-span-1">
							<h1 class="text-xl font-semibold">{{ item.reference }}</h1>
							<p class="flex gap-1 justify-center md:justify-start">
								<Iconify icon="tabler:user" class="w-5 h-5" />
								<span>{{ item.customer_fullname }}</span>
							</p>
						</div>
						<div class="col-span-full md:col-span-1">
							<div class="md:text-right">
								<h1 class="text-2xl font-bold">{{ euro(item.total_paid) }}</h1>
								<small>{{ item.date_add }}</small>
							</div>
						</div>
						<div class="col-span-full md:col-span-1">
							<Button icon="pi pi-eye" @click="openDetail(item)" class="p-button-text !py-1" />
						</div>
					</div>
				</template>
			</PickList>
		</div>
		<DataTable
			:value="products"
			:paginator="true"
			:rows="5"
			:rowHover="true"
			sortField="stock_status"
			:sortOrder="-1"
			dataKey="id"
			responsiveLayout="scroll"
			stripedRows
			class="col-span-full 2xl:col-span-2 border"
		>
			<template #header>Resumen artículos</template>
			<template #empty>No has seleccionado ninguna orden</template>

			<Column field="product_name" header="Producto" :sortable="true" class="whitespace-nowrap" />
			<Column field="product_quantity" header="Solicitado" :sortable="true" class="w-[3em] !text-center" />
			<Column field="stock_quantity" header="Stock" :sortable="true" class="w-[15em] !text-center">
				<template #body="{ data }">
					<span class="font-bold">{{ data.stock_quantity }}</span>
					<Badge v-if="data.stock_quantity > 10" value="IN STOCK" class="!bg-green-300 w-full !text-green-900 whitespace-nowrap" />
					<Badge v-else-if="data.stock_quantity > 0" value="LOW STOCK" class="!bg-orange-300 !text-orange-900 whitespace-nowrap" />
					<Badge v-else value="OUT OF STOCK" class="!bg-red-300 !text-red-900 whitespace-nowrap" />
				</template>
			</Column>
		</DataTable>
	</div>
</template>
