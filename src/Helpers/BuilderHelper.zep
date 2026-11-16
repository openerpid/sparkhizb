namespace Sparkhizb\Helpers;

use Sparkhizb\Helpers\GlobalHelper;
use Sparkhizb\Helpers\IdentityHelper;
use Sparkhizb\Helpers\UmmuHelper;
use Sparkhizb\Helpers\RequestHelper;

class BuilderHelper
{
    /**
     * Deklarasi Properti Class (Wajib di Zephir)
     */
    public request;
    public identity;
    public gHelp;
    public UmHelp;
    public reqH;

    public limit;
    public offset;
    public sort;
    public withCreatedBy;
    public order;
    public search;
    public anywhere;
    public anydate;
    public from_date;
    public to_date;
    public date;
    public datetime;
    public selects;
    public where;
    public condt;

    public function __construct()
    {
        var sortVal;

        let this->request = \Config\Services::request();
        let this->identity = new IdentityHelper();
        let this->gHelp = new GlobalHelper();
        let this->UmHelp = new UmmuHelper();
        let this->reqH = new RequestHelper();

        let this->limit = this->request->getVar("limit");
        let this->offset = this->request->getVar("offset");

        let sortVal = this->request->getVar("sort");
        if empty sortVal {
            let sortVal = this->request->getVar("sort");
        }
        let this->sort = sortVal;

        let this->withCreatedBy = this->request->getVar("created_by");

        if this->sort && strpos(this->sort, ".") !== false {
            let this->sort = null;
        }

        let this->order = this->request->getVar("order");
        if empty this->order {
            let this->order = this->request->getVar("order");
        }

        let this->search = this->request->getVar("search");
        if empty this->search {
            let this->search = this->request->getVar("search");
        }

        let this->anywhere = this->request->getVar("anywhere");
        let this->anydate = this->request->getVar("anydate");

        let this->from_date = this->request->getVar("from_date");
        let this->to_date = this->request->getVar("to_date");
        let this->date = this->request->getVar("date");
        let this->datetime = this->request->getVar("datetime");

        let this->selects = this->request->getVar("selects");
        let this->where = this->request->getVar("where");
        let this->condt = this->request->getVar("conditions");
    }

    public function is_testing(var db_conn, var tb, var builder)
    {
        var isTesting_active, env;

        let isTesting_active = this->request->getJsonVar("isTesting_active");

        if isTesting_active != "N" {
            if db_conn->fieldExists("is_testing", tb) {
                let env = defined("ENVIRONMENT") ? constant("ENVIRONMENT") : "";
                if env == "production" {
                    builder->where("is_testing IS NULL");
                } else {
                    builder->where("is_testing", 1);
                }
            }
        }

        return builder;
    }

    public function isTesting(var db_conn, var tb, var builder)
    {
        return this->is_testing(db_conn, tb, builder);
    }

    public function anyWhere(var builder)
    {
        var anywhere, key, v, from, to;

        let anywhere = this->request->getJsonVar("anywhere");

        if anywhere {
            if is_array(anywhere) {
                for key, v in anywhere {
                    if typeof v == "array" {
                        let v = (object) v;
                    }
                    if typeof v == "object" && isset v->anywhere && (v->anywhere == true || v->anywhere == "true") {
                        if is_array(v->column) {
                            builder->whereIn(v->column, v->value);
                        } else {
                            if isset v->copr {
                                if v->copr == "BETWEEN" {
                                    if isset v->type {
                                        if v->type == "date" {
                                            let from = this->gHelp->dtfFormatter(v->value[0]);
                                            let to = this->gHelp->dtfFormatter(v->value[1]);
                                            builder->where(v->column . " BETWEEN '" . from . "' AND '" . to . "' ");
                                        }
                                    } else {
                                        builder->where(v->column . " BETWEEN " . v->value[0] . " AND " . v->value[1]);
                                    }
                                } else {
                                    if v->copr == "IN" {
                                        builder->whereIn(v->column, v->value);
                                    } else {
                                        builder->where(v->column . " " . v->copr . " ", v->value);
                                    }
                                }
                            } else {
                                if isset v->is_null {
                                    if v->is_null == true || v->is_null == "true" {
                                        builder->where(v->column . " IS NULL ");
                                    }
                                    if isset v->value {
                                        builder->orWhere(v->column, v->value);
                                    }
                                } else {
                                    builder->where(v->column, v->value);
                                }
                            }
                        }
                    }
                }
            } else {
                if typeof anywhere == "object" && isset anywhere->anywhere && (anywhere->anywhere == true || anywhere->anywhere == "true") {
                    builder->whereIn(anywhere->column, anywhere->value);
                }
            }
        }

        return builder;
    }

    public function doSearch(var search_params, var builder)
    {
        var search, key, value;

        let search = this->request->getJsonVar("search");
        if !search {
            let search = this->request->getVar("search");
        }

        if search && search_params {
            builder->groupStart();
            builder->like(search_params[0], search);
            if count(search_params) > 1 {
                for key, value in search_params {
                    if key != 0 {
                        builder->orLike(value, search);
                    }
                }
            }
            builder->groupEnd();
        }

        return builder;
    }

    public function conditions(var params)
    {
        var builder, id, search_params, company_id, account_id, created_by, plant_id, site_project_id;
        var key, value, anydate, from, to;

        let builder = params["builder"];
        let id = params["id"];
        let search_params = params["search_params"];

        if this->selects && this->selects != "*" {
            builder->select(this->selects);
        }

        if fetch company_id, params["company_id"] {
            if company_id {
                builder->where("company_id", company_id);
            }
        }

        if fetch account_id, params["account_id"] {
            if account_id {
                builder->where("created_by", account_id);
            }
        }

        if fetch created_by, params["created_by"] {
            if created_by {
                builder->where("created_by", created_by);
            }
        }

        if fetch plant_id, params["plant_id"] {
            if plant_id {
                builder->where("plant_id", plant_id);
            }
        }

        if fetch site_project_id, params["site_project_id"] {
            if site_project_id {
                builder->where("site_project_id", site_project_id);
            }
        }

        if id {
            if is_array(id) {
                builder->whereIn("id", id);
            } else {
                builder->where("id", id);
            }
        } else {
            if this->where {
                for key, value in this->where {
                    if value != "" {
                        builder->where(key, value);
                    }
                }
            }

            let builder = this->doSearch(search_params, builder);
            let builder = this->anyWhere(builder);

            if this->from_date {
                builder->where("created_at >= ", this->gHelp->dtfFormatter(this->from_date));
            }

            if this->to_date {
                builder->where("created_at <= ", this->gHelp->dttFormatter(this->to_date));
            }

            if this->date {
                if typeof this->date == "object" {
                    if isset this->date->from && this->date->from {
                        builder->where("created_at >= ", this->gHelp->dtfFormatter(this->date->from));
                    }
                    if isset this->date->to && this->date->to {
                        builder->where("created_at <= ", this->gHelp->dttFormatter(this->date->to));
                    }
                }
            }

            if this->datetime {
                if typeof this->datetime == "object" {
                    if isset this->datetime->from && this->datetime->from {
                        builder->where("created_at >= ", this->gHelp->dtfFormatter(this->datetime->from));
                    }
                    if isset this->datetime->to && this->datetime->to {
                        builder->where("created_at <= ", this->gHelp->dttFormatter(this->datetime->to));
                    }
                }
            }

            if this->anydate {
                if typeof this->anydate == "object" {
                    let anydate = isset this->anydate->anydate ? this->anydate->anydate : false;
                    let from = isset this->anydate->from ? this->anydate->from : null;
                    let to = isset this->anydate->to ? this->anydate->to : null;

                    if anydate == true {
                        if from {
                            builder->where("created_at >= ", this->gHelp->dtfFormatter(from));
                        }
                        if to {
                            builder->where("created_at <= ", this->gHelp->dttFormatter(to));
                        }
                    }
                }
            }
        }

        if isset params["deleted_at"] {
            builder->where("deleted_at " . params["deleted_at"]);
        }

        return builder;
    }

    public function conditions2(var params)
    {
        var builder, id, search_params, company_id, account_id, plant_id, site_project_id;
        var key, value;

        let builder = params["builder"];
        let id = params["id"];
        let search_params = params["search_params"];

        if this->selects && this->selects != "*" {
            builder->select(this->selects);
        }

        if fetch company_id, params["company_id"] {
            if company_id {
                builder->where("company_id", company_id);
            }
        }

        if fetch account_id, params["account_id"] {
            builder->where("created_by", account_id);
        }

        if fetch plant_id, params["plant_id"] {
            if plant_id {
                builder->where("plant_id", plant_id);
            }
        }

        if fetch site_project_id, params["site_project_id"] {
            if site_project_id {
                builder->where("site_project_id", site_project_id);
            }
        }

        if id {
            builder->where("id", id);
        } else {
            if this->where {
                for key, value in this->where {
                    if value != "" {
                        builder->where(key, value);
                    }
                }
            }

            if this->search && search_params {
                builder->groupStart();
                builder->like(search_params[0], this->search);
                if count(search_params) > 1 {
                    for key, value in search_params {
                        if key != 0 {
                            builder->orLike(value, this->search);
                        }
                    }
                }
                builder->groupEnd();
            }

            if this->anywhere {
                if is_array(this->anywhere) {
                    for key, value in this->anywhere {
                        if typeof value == "array" {
                            let value = (object) value;
                        }
                        if typeof value == "object" && isset value->anywhere && value->anywhere == true {
                            if is_array(value->column) {
                                builder->whereIn(value->column, value->value);
                            } else {
                                if isset value->copr {
                                    builder->where(value->column . " " . value->copr . " ", value->value);
                                } else {
                                    builder->where(value->column, value->value);
                                }
                            }
                        }
                    }
                } else {
                    if typeof this->anywhere == "object" && isset this->anywhere->anywhere && this->anywhere->anywhere == true {
                        builder->whereIn(this->anywhere->column, this->anywhere->value);
                    }
                }
            }

            if this->from_date {
                builder->where("created_at >=", this->gHelp->dtfFormatter(this->from_date));
            }

            if this->to_date {
                builder->where("created_at <=", this->gHelp->dttFormatter(this->to_date));
            }

            if this->date {
                if typeof this->date == "object" {
                    if isset this->date->from && this->date->from {
                        builder->where("created_at >=", this->gHelp->dtfFormatter(this->date->from));
                    }
                    if isset this->date->to && this->date->to {
                        builder->where("created_at <=", this->gHelp->dttFormatter(this->date->to));
                    }
                }
            }
        }

        builder->where("deleted_at", null);
        builder->where("deleted_at IS NULL");

        return builder;
    }

    public function conditions3(var params)
    {
        var builder, id, search_params, company_id, account_id, created_by, plant_id, site_project_id;
        var key, value, anydate, from, to;

        let builder = params["builder"];
        let id = params["id"];
        let search_params = params["search_params"];

        if this->selects && this->selects != "*" {
            builder->select(this->selects);
        }

        if fetch company_id, params["company_id"] {
            if company_id {
                builder->where("company_id", company_id);
            }
        }

        if fetch account_id, params["account_id"] {
            if account_id {
                builder->where("created_by", account_id);
            }
        }

        if fetch created_by, params["created_by"] {
            if created_by {
                builder->where("created_by", created_by);
            }
        }

        if fetch plant_id, params["plant_id"] {
            if plant_id {
                builder->where("plant_id", plant_id);
            }
        }

        if fetch site_project_id, params["site_project_id"] {
            if site_project_id {
                builder->where("site_project_id", site_project_id);
            }
        }

        if id {
            if is_array(id) {
                builder->whereIn("id", id);
            } else {
                builder->where("id", id);
            }
        } else {
            if this->where {
                for key, value in this->where {
                    if value != "" {
                        builder->where(key, value);
                    }
                }
            }

            let builder = this->doSearch(search_params, builder);
            let builder = this->anyWhere(builder);

            if this->from_date {
                builder->where("created_at >= ", this->gHelp->dtfFormatter(this->from_date));
            }

            if this->to_date {
                builder->where("created_at <= ", this->gHelp->dttFormatter(this->to_date));
            }

            if this->date {
                if typeof this->date == "object" {
                    if isset this->date->from && this->date->from {
                        builder->where("created_at >= ", this->gHelp->dtfFormatter(this->date->from));
                    }
                    if isset this->date->to && this->date->to {
                        builder->where("created_at <= ", this->gHelp->dttFormatter(this->date->to));
                    }
                }
            }

            if this->datetime {
                if typeof this->datetime == "object" {
                    if isset this->datetime->from && this->datetime->from {
                        builder->where("created_at >= ", this->gHelp->dtfFormatter(this->datetime->from));
                    }
                    if isset this->datetime->to && this->datetime->to {
                        builder->where("created_at <= ", this->gHelp->dttFormatter(this->datetime->to));
                    }
                }
            }

            if this->anydate {
                if typeof this->anydate == "object" {
                    let anydate = isset this->anydate->anydate ? this->anydate->anydate : false;
                    let from = isset this->anydate->from ? this->anydate->from : null;
                    let to = isset this->anydate->to ? this->anydate->to : null;

                    if anydate == true {
                        if from {
                            builder->where("created_at >= ", this->gHelp->dtfFormatter(from));
                        }
                        if to {
                            builder->where("created_at <= ", this->gHelp->dttFormatter(to));
                        }
                    }
                }
            }
        }

        builder->where("deleted_at", null);
        builder->where("deleted_at IS NULL");

        return builder;
    }

    public function withJoin(var params)
    {
        var limit, offset, sort, withCreatedBy, order, search, from_date, to_date, date;
        var builder, id, search_params, company_id, key, value;

        let limit = this->request->getJsonVar("limit");
        let offset = this->request->getJsonVar("offset");
        let sort = this->request->getJsonVar("sort");
        let withCreatedBy = this->request->getJsonVar("created_by");

        if sort && strpos(sort, ".") !== false {
            let sort = null;
        }

        let order = this->request->getJsonVar("order");
        let search = this->request->getJsonVar("search");

        let from_date = this->request->getJsonVar("from_date");
        let to_date = this->request->getJsonVar("to_date");
        let date = this->request->getJsonVar("date");

        let builder = params["builder"];
        let id = params["id"];
        let search_params = params["search_params"];

        if fetch company_id, params["company_id"] {
            if company_id {
                builder->where("a.company_id", company_id);
            }
        }

        if isset withCreatedBy && withCreatedBy == true && isset params["account_id"] {
            builder->where("a.created_by", params["account_id"]);
        }

        if id {
            builder->where("a.id", id);
        } else {
            if search {
                if search_params {
                    builder->groupStart();
                    builder->like(search_params[0], search);
                    if count(search_params) > 1 {
                        for key, value in search_params {
                            if key != 0 {
                                builder->orLike(value, search);
                            }
                        }
                    }
                    builder->groupEnd();
                }
            }

            if this->anywhere {
                if is_array(this->anywhere) {
                    for key, value in this->anywhere {
                        if typeof value == "array" {
                            let value = (object) value;
                        }
                        if typeof value == "object" && isset value->anywhere && value->anywhere == true {
                            if is_array(value->column) {
                                builder->whereIn(value->column, value->value);
                            } else {
                                if isset value->copr {
                                    builder->where(value->column . " " . value->copr . " ", value->value);
                                } else {
                                    builder->where(value->column, value->value);
                                }
                            }
                        }
                    }
                } else {
                    if typeof this->anywhere == "object" && isset this->anywhere->anywhere && this->anywhere->anywhere == true {
                        builder->whereIn(this->anywhere->column, this->anywhere->value);
                    }
                }
            }

            if from_date {
                builder->where("a.created_at >=", this->gHelp->dtfFormatter(from_date));
            }

            if to_date {
                builder->where("a.created_at <=", this->gHelp->dttFormatter(to_date));
            }

            if date {
                if typeof date == "object" {
                    if isset date->from && date->from {
                        builder->where("a.created_at >=", this->gHelp->dtfFormatter(date->from));
                    }
                    if isset date->to && date->to {
                        builder->where("a.created_at <=", this->gHelp->dttFormatter(date->to));
                    }
                }
            }
        }

        builder->where("a.deleted_at", null);

        return builder;
    }

    public function conditions0(var params)
    {
        var limit, offset, sort, order, search, date, where, selects;
        var builder, id, search_params, company_id, key, value;

        if this->UmHelp->is_jsonVar() == true {
            let limit = this->request->getJsonVar("limit");
            let offset = this->request->getJsonVar("offset");
            let sort = this->request->getJsonVar("sort");

            let order = this->request->getJsonVar("order");
            let search = this->request->getJsonVar("search");

            let date = this->request->getJsonVar("date");

            let where = this->request->getJsonVar("where");
            let selects = this->request->getJsonVar("selects");
        } else {
            let limit = this->request->getVar("limit");
            let offset = this->request->getVar("offset");
            let sort = this->request->getVar("sort");

            let order = this->request->getVar("order");
            let search = this->request->getVar("search");

            let date = this->request->getVar("date");

            let where = this->request->getVar("where");
            let selects = this->request->getVar("selects");
        }

        let builder = params["builder"];
        let id = params["id"];
        let search_params = params["search_params"];

        if selects {
            builder->select(selects);
        }

        if fetch company_id, params["company_id"] {
            if company_id {
                builder->where("company_id", company_id);
            }
        }

        if id {
            builder->where("id", id);
        } else {
            if where {
                for key, value in where {
                    if value != "" {
                        builder->where(key, value);
                    }
                }
            }

            if search {
                if search_params {
                    builder->groupStart();
                    builder->like(search_params[0], search);
                    if count(search_params) > 1 {
                        for key, value in search_params {
                            if key != 0 {
                                builder->orLike(value, search);
                            }
                        }
                    }
                    builder->groupEnd();
                }
            }

            if this->anywhere {
                if is_array(this->anywhere) {
                    for key, value in this->anywhere {
                        if typeof value == "array" {
                            let value = (object) value;
                        }
                        if typeof value == "object" && isset value->anywhere && value->anywhere == true {
                            if is_array(value->column) {
                                builder->whereIn(value->column, value->value);
                            } else {
                                if isset value->copr {
                                    builder->where(value->column . " " . value->copr . " ", value->value);
                                } else {
                                    builder->where(value->column, value->value);
                                }
                            }
                        }
                    }
                } else {
                    if typeof this->anywhere == "object" && isset this->anywhere->anywhere && this->anywhere->anywhere == true {
                        builder->whereIn(this->anywhere->column, this->anywhere->value);
                    }
                }
            }

            if date {
                if typeof date == "object" {
                    if isset date->from && date->from {
                        builder->where("tanggal >=", this->gHelp->dtfFormatter(date->from));
                    }
                    if isset date->to && date->to {
                        builder->where("tanggal <=", this->gHelp->dttFormatter(date->to));
                    }
                }
            }
        }

        return builder;
    }

    public function withJoin0(var params)
    {
        var limit, offset, sort, order, search, date, from_date, to_date;
        var builder, id, search_params, company_id, key, value;

        if this->UmHelp->is_jsonVar() == true {
            let limit = this->request->getJsonVar("limit");
            let offset = this->request->getJsonVar("offset");
            let sort = this->request->getJsonVar("sort");
            let order = this->request->getJsonVar("order");
            let search = this->request->getJsonVar("search");
            let date = this->request->getJsonVar("date");
        } else {
            let limit = this->request->getVar("limit");
            let offset = this->request->getVar("offset");
            let sort = this->request->getVar("sort");
            let order = this->request->getVar("order");
            let search = this->request->getVar("search");
            let date = this->request->getVar("date");
        }

        if sort && strpos(sort, ".") !== false {
            let sort = null;
        }

        let builder = params["builder"];
        let id = params["id"];
        let search_params = params["search_params"];

        if fetch company_id, params["company_id"] {
            if company_id {
                builder->where("a.company_id", company_id);
            }
        }

        if id {
            builder->where("a.id", id);
        } else {
            if search {
                if search_params {
                    builder->groupStart();
                    builder->like(search_params[0], search);
                    if count(search_params) > 1 {
                        for key, value in search_params {
                            if key != 0 {
                                builder->orLike(value, search);
                            }
                        }
                    }
                    builder->groupEnd();
                }
            }

            if this->anywhere {
                if is_array(this->anywhere) {
                    for key, value in this->anywhere {
                        if typeof value == "array" {
                            let value = (object) value;
                        }
                        if typeof value == "object" && isset value->anywhere && value->anywhere == true {
                            if is_array(value->column) {
                                builder->whereIn(value->column, value->value);
                            } else {
                                if isset value->copr {
                                    builder->where(value->column . " " . value->copr . " ", value->value);
                                } else {
                                    builder->where(value->column, value->value);
                                }
                            }
                        }
                    }
                } else {
                    if typeof this->anywhere == "object" && isset this->anywhere->anywhere && this->anywhere->anywhere == true {
                        builder->whereIn(this->anywhere->column, this->anywhere->value);
                    }
                }
            }

            let from_date = isset params["from_date"] ? params["from_date"] : null;
            let to_date = isset params["to_date"] ? params["to_date"] : null;

            if from_date {
                builder->where("a.created_at >=", this->gHelp->dtfFormatter(from_date));
            }

            if to_date {
                builder->where("a.created_at <=", this->gHelp->dttFormatter(to_date));
            }

            if date {
                if typeof date == "object" {
                    if isset date->from && date->from {
                        builder->where("a.created_at >=", this->gHelp->dtfFormatter(date->from));
                    }
                    if isset date->to && date->to {
                        builder->where("a.created_at <=", this->gHelp->dttFormatter(date->to));
                    }
                }
            }
        }

        return builder;
    }

    public function conditions_hill(var params)
    {
        var limit, offset, sort, order, search, date, where;
        var builder, id, search_params, company_id, key, value;

        if this->UmHelp->is_jsonVar() == true {
            let limit = this->request->getJsonVar("limit");
            let offset = this->request->getJsonVar("offset");
            let sort = this->request->getJsonVar("sort");
            let order = this->request->getJsonVar("order");
            let search = this->request->getJsonVar("search");
            let date = this->request->getJsonVar("date");
            let where = this->request->getJsonVar("where");
        } else {
            let limit = this->request->getVar("limit");
            let offset = this->request->getVar("offset");
            let sort = this->request->getVar("sort");
            let order = this->request->getVar("order");
            let search = this->request->getVar("search");
            let date = this->request->getVar("date");
            let where = this->request->getVar("where");
        }

        let builder = params["builder"];
        let id = params["id"];
        let search_params = params["search_params"];

        if fetch company_id, params["company_id"] {
            if company_id {
                builder->where("company_id", company_id);
            }
        }

        if id {
            builder->where("id", id);
        } else {
            if search {
                if search_params {
                    builder->groupStart();
                    builder->like(search_params[0], search);
                    if count(search_params) > 1 {
                        for key, value in search_params {
                            if key != 0 {
                                builder->orLike(value, search);
                            }
                        }
                    }
                    builder->groupEnd();
                }
            }

            if date {
                if typeof date == "object" {
                    if isset date->from && date->from {
                        builder->where("tanggal >=", this->gHelp->dtfFormatter(date->from));
                    }
                    if isset date->to && date->to {
                        builder->where("tanggal <=", this->gHelp->dttFormatter(date->to));
                    }
                }
            }
        }

        return builder;
    }

    public function withJoin_hill(var params)
    {
        var limit, offset, sort, order, search, date, from_date, to_date;
        var builder, id, search_params, company_id, key, value;

        let limit = this->request->getJsonVar("limit");
        let offset = this->request->getJsonVar("offset");
        let sort = this->request->getJsonVar("sort");

        if sort && strpos(sort, ".") !== false {
            let sort = null;
        }

        let order = this->request->getJsonVar("order");
        let search = this->request->getJsonVar("search");
        let date = this->request->getJsonVar("date");

        let builder = params["builder"];
        let id = params["id"];
        let search_params = params["search_params"];

        if fetch company_id, params["company_id"] {
            if company_id {
                builder->where("a.company_id", company_id);
            }
        }

        if id {
            builder->where("a.id", id);
        } else {
            if search {
                if search_params {
                    builder->groupStart();
                    builder->like(search_params[0], search);
                    if count(search_params) > 1 {
                        for key, value in search_params {
                            if key != 0 {
                                builder->orLike(value, search);
                            }
                        }
                    }
                    builder->groupEnd();
                }
            }

            let from_date = isset params["from_date"] ? params["from_date"] : null;
            let to_date = isset params["to_date"] ? params["to_date"] : null;

            if from_date {
                builder->where("a.created_at >=", this->gHelp->dtfFormatter(from_date));
            }

            if to_date {
                builder->where("a.created_at <=", this->gHelp->dttFormatter(to_date));
            }

            if date {
                if typeof date == "object" {
                    if isset date->from && date->from {
                        builder->where("a.created_at >=", this->gHelp->dtfFormatter(date->from));
                    }
                    if isset date->to && date->to {
                        builder->where("a.created_at <=", this->gHelp->dttFormatter(date->to));
                    }
                }
            }
        }

        return builder;
    }

    public function dt_conditions(var params)
    {
        var length, limit, offset, sort, order, search, date;
        var builder, id, search_params, company_id, key, value;

        let length = this->request->getJsonVar("length");
        let limit = this->request->getJsonVar("limit");
        let offset = this->request->getJsonVar("offset");
        let sort = this->request->getJsonVar("sort");
        let order = this->request->getJsonVar("order");
        let search = this->request->getJsonVar("search");

        if is_array(search) && isset search["value"] {
            let search = search["value"];
        } else {
            if typeof search == "object" && isset search->value {
                let search = search->value;
            } else {
                let search = "";
            }
        }

        let date = this->request->getJsonVar("date");

        let builder = params["builder"];
        let id = params["id"];
        let search_params = params["search_params"];

        if fetch company_id, params["company_id"] {
            if company_id {
                builder->where("company_id", company_id);
            }
        }

        if id {
            builder->where("id", id);
        } else {
            if this->where {
                for key, value in this->where {
                    if value != "" {
                        builder->where(key, value);
                    }
                }
            }

            if search {
                if search_params {
                    builder->groupStart();
                    builder->like(search_params[0], search);
                    if count(search_params) > 1 {
                        for key, value in search_params {
                            if key != 0 {
                                builder->orLike(value, search);
                            }
                        }
                    }
                    builder->groupEnd();
                }
            }

            if this->anywhere {
                if is_array(this->anywhere) {
                    for key, value in this->anywhere {
                        if typeof value == "array" {
                            let value = (object) value;
                        }
                        if typeof value == "object" && isset value->anywhere && value->anywhere == true {
                            if is_array(value->column) {
                                builder->whereIn(value->column, value->value);
                            } else {
                                if isset value->copr {
                                    builder->where(value->column . " " . value->copr . " ", value->value);
                                } else {
                                    builder->where(value->column, value->value);
                                }
                            }
                        }
                    }
                } else {
                    if typeof this->anywhere == "object" && isset this->anywhere->anywhere && this->anywhere->anywhere == true {
                        builder->whereIn(this->anywhere->column, this->anywhere->value);
                    }
                }
            }

            if date {
                if typeof date == "object" {
                    if isset date->from && date->from {
                        builder->where("tanggal >=", this->gHelp->dtfFormatter(date->from));
                    }
                    if isset date->to && date->to {
                        builder->where("tanggal <=", this->gHelp->dttFormatter(date->to));
                    }
                }
            }
        }

        return builder;
    }

    public function delete_conditions(var params)
    {
        var where, builder, company_id, created_by, deleted_by, payload, key, value;

        let where = this->request->getJsonVar("where");
        let builder = params["builder"];
        let company_id = params["company_id"];
        let created_by = params["created_by"];
        let deleted_by = params["deleted_by"];

        if deleted_by == true {
            let payload = [
                "deleted_at" : date("Y-m-d H:i:s"),
                "deleted_by" : this->identity->account_id()
            ];
        } else {
            let payload = [
                "deleted_at" : date("Y-m-d H:i:s")
            ];
        }

        builder->set(payload);

        if is_array(where) {
            for key, value in where {
                if value {
                    if is_array(value) {
                        builder->whereIn(key, value);
                    } else {
                        builder->where(key, value);
                    }
                }
            }
        }

        if company_id == true {
            builder->where("company_id", this->identity->company_id());
        }

        if created_by == true {
            builder->where("created_by", this->identity->account_id());
        }

        builder->update();

        return builder;
    }

    public function dynamic_conditions(var params)
    {
        if this->identity->isAJAX_datatables() {
            // code...
        }
    }

    public function delete(var id, var builder)
    {
        var payload;

        let payload = [
            "deleted_at" : date("Y-m-d H:i:s"),
            "deleted_by" : this->identity->account_id()
        ];

        if is_array(id) {
            let builder = builder->whereIn("id", id);
        } else {
            let builder = builder->where("id", id);
        }

        return builder->set(payload)->update();
    }

    public function delete2(var id, var builder)
    {
        var payload;

        let payload = [
            "deleted_at" : date("Y-m-d H:i:s"),
            "deleted_by_text" : this->identity->username()
        ];

        if is_array(id) {
            let builder = builder->whereIn("id", id);
        } else {
            let builder = builder->where("id", id);
        }

        return builder->set(payload)->update();
    }

    public function filterID(var builder)
    {
        var ids;

        let ids = this->request->getJsonVar("ids");
        if !ids {
            let ids = this->request->getVar("ids");
            if ids {
                let ids = json_decode(ids);
            }
        }

        if ids {
            builder->whereIn("id", ids);
        }

        return builder;
    }

    public function filter(var builder)
    {
        var filter_type, filter, key, value;

        let filter_type = this->request->getJsonVar("filter_type");
        let filter = this->request->getJsonVar("filter");
        if !filter {
            let filter = this->request->getVar("filter");
            if filter {
                let filter = json_decode(filter);
            }
        }

        if filter {
            for key, value in filter {
                if key != "undefined" {
                    if filter_type == "like" {
                        builder->like(key, value);
                    } else {
                        builder->where(key, value);
                    }
                }
            }
        }

        return builder;
    }

    public function filter2(var builder, var filter, var filter_type = null)
    {
        var key, value;

        if filter && typeof filter == "string" {
            let filter = json_decode(filter);
        }

        if filter {
            for key, value in filter {
                if key != "undefined" {
                    if filter_type == "like" {
                        builder->like(key, value);
                    } else {
                        builder->where(key, value);
                    }
                }
            }
        }

        return builder;
    }

    public function payloadInsert(var db_conn, var tb, var payload)
    {
        var env;

        if db_conn->fieldExists("company_id", tb) {
            let payload["company_id"] = this->identity->company_id();
        }

        if db_conn->fieldExists("created_by", tb) {
            let payload["created_by"] = this->identity->account_id();
        }

        if db_conn->fieldExists("is_testing", tb) {
            let env = defined("ENVIRONMENT") ? constant("ENVIRONMENT") : "";
            if env != "production" {
                let payload["is_testing"] = 1;
            }
        }

        return payload;
    }

    public function payloadInsertBatch(var db_conn, var tb, var payload)
    {
        var key, value, env;

        for key, value in payload {
            if db_conn->fieldExists("company_id", tb) {
                if typeof value == "object" {
                    let payload[key]->company_id = this->identity->company_id();
                } else {
                    let payload[key]["company_id"] = this->identity->company_id();
                }
            }

            if db_conn->fieldExists("created_by", tb) {
                if typeof value == "object" {
                    let payload[key]->created_by = this->identity->account_id();
                } else {
                    let payload[key]["created_by"] = this->identity->account_id();
                }
            }

            if db_conn->fieldExists("is_testing", tb) {
                let env = defined("ENVIRONMENT") ? constant("ENVIRONMENT") : "";
                if env != "production" {
                    if typeof value == "object" {
                        let payload[key]->is_testing = 1;
                    } else {
                        let payload[key]["is_testing"] = 1;
                    }
                }
            }
        }

        return payload;
    }

    public function payloadUpdate(var db_conn, var tb, var payload)
    {
        if db_conn->fieldExists("updated_by", tb) {
            let payload["updated_by"] = this->identity->account_id();
        }

        return payload;
    }

    public function conditions_with_dbconn(var params)
    {
        var builder, id, company_id, search_params, db_conn, tb;
        var account_id, created_by, plant_id, site_project_id;
        var value, env, from, to, anydate;

        let builder = params["builder"];
        let id = params["id"];
        let company_id = isset params["company_id"] ? params["company_id"] : "";
        let search_params = params["search_params"];
        let db_conn = params["db_conn"];
        let tb = params["tb"];

        if this->selects && this->selects != "*" {
            builder->select(this->selects);
        }

        if isset params["is_mutabannat"] {
            if params["is_mutabannat"] == true {
                if db_conn->fieldExists("is_mutabannat", tb) {
                    builder->where("is_mutabannat", 1);
                }
            }
        } else {
            if isset params["company_id"] {
                let company_id = params["company_id"];
                if company_id {
                    builder->where("company_id", company_id);
                }
            }
        }

        if fetch account_id, params["account_id"] {
            if account_id {
                builder->where("created_by", account_id);
            }
        }

        if fetch created_by, params["created_by"] {
            if created_by {
                builder->where("created_by", created_by);
            }
        }

        if fetch plant_id, params["plant_id"] {
            if plant_id {
                builder->where("plant_id", plant_id);
            }
        }

        if fetch site_project_id, params["site_project_id"] {
            if site_project_id {
                builder->where("site_project_id", site_project_id);
            }
        }

        if id {
            if is_array(id) {
                builder->whereIn("id", id);
            } else {
                builder->where("id", id);
            }
        } else {
            if this->where {
                if isset this->where[1] && this->where[1] != "" {
                    builder->where(this->where[0], this->where[1]);
                }
            }

            if this->search && search_params {
                builder->groupStart();
                builder->like(search_params[0], this->search);
                if count(search_params) > 1 {
                    for value in search_params {
                        if value != search_params[0] {
                            builder->orLike(value, this->search);
                        }
                    }
                }
                builder->groupEnd();
            }

            if this->anywhere {
                if is_array(this->anywhere) {
                    for value in this->anywhere {
                        if is_array(value) {
                            let value = (object) value;
                        }

                        if typeof value == "object" && isset value->anywhere && (value->anywhere == "true" || value->anywhere == true) {
                            if is_array(value->column) {
                                builder->whereIn(value->column, value->value);
                            } else {
                                if isset value->copr {
                                    if value->copr == "BETWEEN" {
                                        if isset value->type {
                                            if value->type == "date" {
                                                let from = this->gHelp->dtfFormatter(value->value[0]);
                                                let to = this->gHelp->dtfFormatter(value->value[1]);
                                                builder->where(value->column . " BETWEEN '" . from . "' AND '" . to . "' ");
                                            }
                                        } else {
                                            builder->where(value->column . " BETWEEN " . value->value[0] . " AND " . value->value[1]);
                                        }
                                    } else {
                                        builder->where(value->column . " " . value->copr . " ", value->value);
                                    }
                                } else {
                                    if isset value->is_null {
                                        if value->is_null == "true" || value->is_null == true {
                                            builder->where(value->column . " IS NULL ");
                                        }
                                        if isset value->value {
                                            builder->orWhere(value->column, value->value);
                                        }
                                    } else {
                                        builder->where(value->column, value->value);
                                    }
                                }
                            }
                        }
                    }
                } else {
                    if typeof this->anywhere == "object" && isset this->anywhere->anywhere && (this->anywhere->anywhere == "true" || this->anywhere->anywhere == true) {
                        builder->whereIn(this->anywhere->column, this->anywhere->value);
                    }
                }
            }

            if this->from_date {
                builder->where("created_at >= ", this->gHelp->dtfFormatter(this->from_date));
            }

            if this->to_date {
                builder->where("created_at <= ", this->gHelp->dttFormatter(this->to_date));
            }

            if this->date {
                if typeof this->date == "object" {
                    if isset this->date->from && this->date->from {
                        builder->where("created_at >= ", this->gHelp->dtfFormatter(this->date->from));
                    }
                    if isset this->date->to && this->date->to {
                        builder->where("created_at <= ", this->gHelp->dttFormatter(this->date->to));
                    }
                }
            }

            if this->datetime {
                if typeof this->datetime == "object" {
                    if isset this->datetime->from && this->datetime->from {
                        builder->where("created_at >= ", this->gHelp->dtfFormatter(this->datetime->from));
                    }
                    if isset this->datetime->to && this->datetime->to {
                        builder->where("created_at <= ", this->gHelp->dttFormatter(this->datetime->to));
                    }
                }
            }

            if this->anydate {
                if typeof this->anydate == "object" {
                    let anydate = isset this->anydate->anydate ? this->anydate->anydate : false;
                    let from = isset this->anydate->from ? this->anydate->from : null;
                    let to = isset this->anydate->to ? this->anydate->to : null;

                    if anydate == true {
                        if from {
                            builder->where("created_at >= ", this->gHelp->dtfFormatter(from));
                        }
                        if to {
                            builder->where("created_at <= ", this->gHelp->dttFormatter(to));
                        }
                    }
                }
            }
        }

        if db_conn->fieldExists("deleted_at", tb) {
            builder->where("deleted_at IS NULL");
        }

        if isset params["is_testing"] {
            if params["is_testing"] == false {
                if db_conn->fieldExists("is_testing", tb) {
                    let env = defined("ENVIRONMENT") ? constant("ENVIRONMENT") : "";
                    if env == "production" {
                        builder->where("is_testing IS NULL");
                    } else {
                        builder->where("is_testing", 1);
                    }
                }
            }
        }

        return builder;
    }

    public function selectIdentity() -> array
    {
        return [
            "iCreated.name as created_by_name",
            "iUpdated.name as updated_by_name"
        ];
    }
}