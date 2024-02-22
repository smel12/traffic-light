@extends('layouts.applayout')

@section('title', 'ТЗ "Светофор" - REVERED {PRO}')

@section('header')
	@parent
	ТЗ "Светофор" - REVERED {PRO}
@endsection

@section('content')
	@parent
		<div hidden id="app_session_id">{{<?= session() -> getId() ?>}}</div>
		<div class="flex flex-col w-full justify-center">
			<div class="flow-root w-fool p-3">
				<div class="grid grid-cols-2 justify-items-center">
					<div class="w-32 h-80 mr-4 rounded-2xl bg-gray-600 justify-self-end">
						<canvas id="traffic_light" width="128" height="320"></canvas>
					</div>
					<div class="flex flex-col ml-4 justify-self-start justify-end">
						<button name="direction" value="up" id="letsgo_button" class="px-5 py-1.5 bg-blue-600
							text-white text-3xl leading-tight rounded-full
							active:bg-blue-800">Вперёд</button>
					</div>
				</div>
				<div class="flow-root w-fool pt-7">
					<div class="m-auto flex flex-col w-3/4 justify-items-center">
						<table class="table-auto border-white bg-black font-mono text-base">
							<thead>
								<tr class="text-white">
									<th class="w-20 border">Время</td>
									<th class="w-28 border">Дата</td>
									<th class="border">Сообщение</td>
								</tr>
							</thead>
						</table>
					</div>
					<div class="m-auto flex flex-col w-3/4 justify-items-center h-32 overflow-auto">
						<table id="log_table" class="text-yellow-400 table-auto border-white bg-black font-mono text-base leading-4">
							<tbody class="overflow-y-scroll">
								<tr class="text-black">
									<td class="w-20 pl-1">.</td><td class="w-28 pl-2"></td>
									<td class="pl-3"></td>
								</tr>
								<tr class="text-black">
									<td class="w-20 pl-1">.</td><td class="w-28 pl-2"></td>
									<td class="pl-3"></td>
								</tr>
								<tr class="text-black">
									<td class="w-20 pl-1">.</td><td class="w-28 pl-2"></td>
									<td class="pl-3"></td>
								</tr>
								<tr class="text-black">
									<td class="w-20 pl-1">.</td><td class="w-28 pl-2"></td>
									<td class="pl-3"></td>
								</tr>
								<tr class="text-black">
									<td class="w-20 pl-1">.</td><td class="w-28 pl-2"></td>
									<td class="pl-3"></td>
								</tr>
								<tr class="text-black">
									<td class="w-20 pl-1">.</td><td class="w-28 pl-2"></td>
									<td class="pl-3"></td>
								</tr>
								<tr class="text-black">
									<td class="w-20 pl-1">.</td><td class="w-28 pl-2"></td>
									<td class="pl-3"></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
@endsection

@section('sidebar')
	@parent
@endsection

@section('footer')
	@parent
	<span class="text-xl font-bold my-2"></span>
@endsection
