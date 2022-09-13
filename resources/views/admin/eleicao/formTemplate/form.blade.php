@csrf
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="name">Nome</label>
                    <input
                        type="text"
                        class="form-control"
                        id="name"
                        name="name"
                        value="{{ old('name', isset($eleicoes) ? $eleicoes->name : '') }}"
                    >
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label for="startDate">Data de início</label>
                    <input
                        type="text"
                        class="form-control"
                        id="startDate"
                        name="startDate"
                        value="{{ old('startDate', isset($eleicoes) ? $eleicoes->startDate_formatted : '') }}"
                        data-mask="00/00/0000 00:00"
                    >
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label for="endDate">Data do fim</label>
                    <input
                        type="text"
                        class="form-control"
                        id="endDate"
                        name="endDate"
                        value="{{ old('endDate', isset($eleicoes) ? $eleicoes->endDate_formatted : '') }}"
                        data-mask="00/00/0000 00:00"
                    >
                </div>
            </div>
            <button type="submit" class="btn btn-success">Salvar</button>
        </div>
