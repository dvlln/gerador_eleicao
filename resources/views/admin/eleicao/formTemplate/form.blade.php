@csrf

    <div class="row">

        {{-- NOME --}}
            <div class="col-lg-12">
                <div class="form-group">
                    <label for="name">Nome</label>
                    <input
                        type="text"
                        class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                        id="name"
                        name="name"
                        value="{{ old('name', isset($eleicoes) ? $eleicoes->name : '') }}"
                    >
                    <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                </div>
            </div>
        {{-- END NOME --}}

        {{-- INSCRICAO --}}

            {{-- TITULO --}}
            <div class="col-lg-12">
                <h3 class="bg-info text-white text-center rounded p-1">INSCRIÇÃO</h3>
            </div>

            {{-- DATA INICIAL --}}
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="start_date_inscricao">Data de início</label>
                    <input
                        type="date"
                        class="form-control {{ $errors->has('start_date_inscricao') ? 'is-invalid' : '' }}"
                        id="start_date_inscricao"
                        name="start_date_inscricao"
                        value="{{ old('start_date_inscricao', isset($eleicoes) ? $start_date_inscricao : '') }}"
                    >
                    <div class="invalid-feedback">{{ $errors->first('start_date_inscricao') }}</div>
                </div>
            </div>

            {{-- HORA INICIAL --}}
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="start_time_inscricao">Hora de início</label>
                    <input
                        type="time"
                        class="form-control {{ $errors->has('start_time_inscricao') ? 'is-invalid' : '' }}"
                        id="start_time_inscricao"
                        name="start_time_inscricao"
                        value="{{ old('start_time_inscricao', isset($eleicoes) ? $start_time_inscricao : '') }}"
                    >
                    <div class="invalid-feedback">{{ $errors->first('start_time_inscricao') }}</div>
                </div>
            </div>

            {{-- DATA FINAL --}}
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="end_date_inscricao">Data do fim</label>
                    <input
                        type="date"
                        class="form-control {{ $errors->has('end_date_inscricao') ? 'is-invalid' : '' }}"
                        id="end_date_inscricao"
                        name="end_date_inscricao"
                        value="{{ old('end_date_inscricao', isset($eleicoes) ? $end_date_inscricao : '') }}"
                    >
                    <div class="invalid-feedback">{{ $errors->first('end_date_inscricao') }}</div>
                </div>
            </div>

            {{-- HORA FINAL --}}
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="end_time_inscricao">Hora do fim</label>
                    <input
                        type="time"
                        class="form-control {{ $errors->has('end_time_inscricao') ? 'is-invalid' : '' }}"
                        id="end_time_inscricao"
                        name="end_time_inscricao"
                        value="{{ old('end_time_inscricao', isset($eleicoes) ? $end_time_inscricao : '') }}"
                    >
                    <div class="invalid-feedback">{{ $errors->first('end_time_inscricao') }}</div>
                </div>
            </div>

        {{-- END INSCRICAO --}}

        {{-- DEPURACAO --}}

            {{-- TITULO --}}
            <div class="col-lg-12">
                <h3 class="bg-info text-white text-center rounded p-1">DEPURAÇÃO</h3>
            </div>

            {{-- DATA INICIAL --}}
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="start_date_depuracao">Data de início</label>
                    <input
                        type="date"
                        class="form-control {{ $errors->has('start_date_depuracao') ? 'is-invalid' : '' }}"
                        id="start_date_depuracao"
                        name="start_date_depuracao"
                        value="{{ old('start_date_depuracao', isset($eleicoes) ? $start_date_depuracao : '') }}"
                    >
                    <div class="invalid-feedback">{{ $errors->first('start_date_depuracao') }}</div>
                </div>
            </div>

            {{-- HORA INICIAL --}}
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="start_time_depuracao">Hora de início</label>
                    <input
                        type="time"
                        class="form-control {{ $errors->has('start_time_depuracao') ? 'is-invalid' : '' }}"
                        id="start_time_depuracao"
                        name="start_time_depuracao"
                        value="{{ old('start_time_depuracao', isset($eleicoes) ? $start_time_depuracao : '') }}"
                    >
                    <div class="invalid-feedback">{{ $errors->first('start_time_depuracao') }}</div>
                </div>
            </div>

            {{-- DATA FINAL --}}
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="end_date_depuracao">Data do fim</label>
                    <input
                        type="date"
                        class="form-control {{ $errors->has('end_date_depuracao') ? 'is-invalid' : '' }}"
                        id="end_date_depuracao"
                        name="end_date_depuracao"
                        value="{{ old('end_date_depuracao', isset($eleicoes) ? $end_date_depuracao : '') }}"
                    >
                    <div class="invalid-feedback">{{ $errors->first('end_date_depuracao') }}</div>
                </div>
            </div>

            {{-- HORA FINAL --}}
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="end_time_depuracao">Hora do fim</label>
                    <input
                        type="time"
                        class="form-control {{ $errors->has('end_time_depuracao') ? 'is-invalid' : '' }}"
                        id="end_time_depuracao"
                        name="end_time_depuracao"
                        value="{{ old('end_time_depuracao', isset($eleicoes) ? $end_time_depuracao : '') }}"
                    >
                    <div class="invalid-feedback">{{ $errors->first('end_time_depuracao') }}</div>
                </div>
            </div>

        {{-- END DEPURACAO --}}

        {{-- ELEICAO --}}

            {{-- TITULO --}}
            <div class="col-lg-12">
                <h3 class="bg-info text-white text-center rounded p-1">ELEIÇÃO</h3>
            </div>

            {{-- DATA INICIAL --}}
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="start_date_eleicao">Data de início</label>
                    <input
                        type="date"
                        class="form-control {{ $errors->has('start_date_eleicao') ? 'is-invalid' : '' }}"
                        id="start_date_eleicao"
                        name="start_date_eleicao"
                        value="{{ old('start_date_eleicao', isset($eleicoes) ? $start_date_eleicao : '') }}"
                    >
                    <div class="invalid-feedback">{{ $errors->first('start_date_eleicao') }}</div>
                </div>
            </div>

            {{-- HORA INICIAL --}}
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="start_time_eleicao">Hora de início</label>
                    <input
                        type="time"
                        class="form-control {{ $errors->has('start_time_eleicao') ? 'is-invalid' : '' }}"
                        id="start_time_eleicao"
                        name="start_time_eleicao"
                        value="{{ old('start_time_eleicao', isset($eleicoes) ? $start_time_eleicao : '') }}"
                    >
                    <div class="invalid-feedback">{{ $errors->first('start_time_eleicao') }}</div>
                </div>
            </div>

            {{-- DATA FINAL --}}
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="end_date_eleicao">Data do fim</label>
                    <input
                        type="date"
                        class="form-control {{ $errors->has('end_date_eleicao') ? 'is-invalid' : '' }}"
                        id="end_date_eleicao"
                        name="end_date_eleicao"
                        value="{{ old('end_date_eleicao', isset($eleicoes) ? $end_date_eleicao : '') }}"
                    >
                    <div class="invalid-feedback">{{ $errors->first('end_date_eleicao') }}</div>
                </div>
            </div>

            {{-- HORA FINAL --}}
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="end_time_eleicao">Hora do fim</label>
                    <input
                        type="time"
                        class="form-control {{ $errors->has('end_time_eleicao') ? 'is-invalid' : '' }}"
                        id="end_time_eleicao"
                        name="end_time_eleicao"
                        value="{{ old('end_time_eleicao', isset($eleicoes) ? $end_time_eleicao : '') }}"
                    >
                    <div class="invalid-feedback">{{ $errors->first('end_time_eleicao') }}</div>
                </div>
            </div>

        {{-- END ELEICAO --}}

        {{-- SUBMIT --}}
            <div class="col-12">
                <button type="submit" class="btn btn-success btn-block">Salvar</button>
            </div>
        {{-- END SUBMIT --}}
    </div>


