<%@page import="br.com.oop.Fornecedor"%>
<%@page import="br.com.oop.Database"%>
<!DOCTYPE html>
<%
    if (request.getParameter("_method") != null) {
        Fornecedor f;
        switch (request.getParameter("_method").toString()) {
            //Fornecedores: com nome, razão social, cnpj, email, telefone e endereço
            case "insert":
                f = new Fornecedor();
                f.setNome(request.getParameter("nm_fornecedor_salvar"));
                f.setEmail(request.getParameter("email_empresa_salvar"));
                f.setTelefone(request.getParameter("tel_empresa_salvar"));
                f.setEndereco(request.getParameter("endereco_empresa_salvar"));
                f.setCnpj(request.getParameter("cd_empresa_salvar"));
                f.setNome_social(request.getParameter("nm_empresa_salvar"));
                Database.insert("fornecedor", f);
                response.sendRedirect(request.getRequestURI());
                break;
            case "update":
                
                String[] dados = new String[6];
                dados[0] = request.getParameter("nm_fornecedor_editar");
                dados[1] = request.getParameter("email_empresa_editar");
                dados[2] = request.getParameter("tel_empresa_editar");
                dados[3] = request.getParameter("endereco_empresa_editar");
                dados[4] = request.getParameter("cd_empresa_editar");
                dados[5] = request.getParameter("nm_empresa_editar");
                Database.update("fornecedor", dados, Integer.parseInt(request.getParameter("id_editar")));
                response.sendRedirect(request.getRequestURI());
                break;
            case "delete":
                Database.delete("fornecedor", Integer.parseInt(request.getParameter("id_delete")));
                response.sendRedirect(request.getRequestURI());
                break;
            default:
                break;
        }
    }
%>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Projeto POO - Fornecedores</title>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="css/simple-sidebar.css">

    </head>

    <body>
        <div class="container-fluid">
            <%@include file="__includes/sidebar.jsp" %>

            <!-- A classe col-md-offset-2 "pula" duas colunas e col-md-10, bem, diz que a div terÃ¡ o tamanho de dez colunas -->
            <div class="main-content col-md-10 col-md-offset-2 col-sm-8">
                <div class="row">
                    <div class="search-bar">
                        <div class="form-group has-feedback">
                            <i class="glyphicon glyphicon-search form-control-feedback"></i>
                            <input type="search" class="form-control" placeholder="Procure por um cliente, fornecedor etc..." maxlength="20" /> 
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 text-center">
                        <h3 style="text-shadow: text-right">Fornecedores</h3>
                    </div>
                    <div class="tabela">
                        <% if (!Database.getFornecedorList().isEmpty()) {%>
                        <table class="table table-striped conf-tabela">
                            <thead>
                                <tr>
                                    <td class="text-center">Nome</td>
                                    <td class="text-center">Telefone</td>
                                    <td class="text-center">Email</td>
                                    <td class="text-center"><!-- Editar --></td>
                                    <td class="text-center"><!-- Excluir --></td>
                                </tr>
                            </thead>
                            <tbody>
                                <% for (Fornecedor f : Database.getFornecedorList()) {%>
                                <tr data-id="<%= Database.getFornecedorList().indexOf(f)%>">
                                    <td class="text-center"><%= f.getNome()%></td>
                                    <td class="text-center"><%= f.getTelefone()%></td>
                                    <td class="text-center"><%= f.getEmail()%></td>
                                    <td class="text-center">
                                        <a role="button" class="editarConta" data-toggle="modal" data-name="btn-altera-fornecedor" data-target="#modalEdicao" ><i class="glyphicon glyphicon-pencil"></i></a>
                                    </td>
                                    <td class="text-center">
                                        <a role="button" class="excluirConta" data-toggle="modal" data-target="#modalDelecao" data-name="btn-excui-cliente"><i class="glyphicon glyphicon-trash"></i></a>
                                    </td>
                                </tr>
                                <% } %>
                            </tbody>
                        </table>   
                        <% } else {%>
                        <div class="alert alert-warning text-center" style="">
                            <strong>Nenhum fornecedor foi cadastrado :/</strong> 
                        </div>
                        <% }%>
                    </div>
                </div>
                <!-- BotÃ£o de inclusÃ£o de cadastro-->
                <div class="row">
                    <div class="col-md-12 text-right">
                        <a role="button" data-toggle="modal" data-target="#novoFornecedor" style="width: 2em; border-radius: 50%; background-color: #51B8B4; margin-top: 4%; font-size: 2em; color: white" class="btn btn-md">+</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de criação -->
        <div id="novoFornecedor" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i></button>
                        <h4 class="modal-title">Novo fornecedor</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form role="form" action="#" data-name="form-add">
                                    <input type="hidden" name="_method" value="insert" />
                                    <div class="form-group has-feedback">
                                        <label for="nm_fornecedor_salvar"><strong>Nome do fornecedor</strong></label>
                                        <input type="text" name="nm_fornecedor_salvar" id="nm_fornecedor_salvar" class="form-control add" placeholder="Digite o nome do fornecedor" />
                                        <span class="" data-name="icon-error"></span>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <label for="nm_empresa_salvar"><strong>Nome da empresa</strong></label>
                                        <input type="text" name="nm_empresa_salvar" id="nm_empresa_salvar"  class="form-control add" placeholder="Digite o nome da empresa" />
                                        <span class="" data-name="icon-error"></span>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <label for="cd_empresa_salvar"><strong>CNPJ da empresa</strong></label>
                                        <input type="text" name="cd_empresa_salvar" id="cd_empresa_salvar" data-validate='cnpj' class="form-control add" placeholder="Digite o CNPJ da empresa" />
                                        <span class="" data-name="icon-error"></span>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <label for="email_empresa_salvar"><strong>Email da empresa</strong></label>
                                        <input type="text" name="email_empresa_salvar" id="email_empresa_salvar" class="form-control add" placeholder="Digite o email da empresa" />
                                        <span class="" data-name="icon-error"></span>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <label for="tel_empresa_salvar"><strong>Telefone da empresa</strong></label>
                                        <input type="text" name="tel_empresa_salvar" data-validate='phone' id="tel_empresa_salvar" class="form-control add" placeholder="Digite o telefone da empresa" />
                                        <span class="" data-name="icon-error"></span>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <label for="endereco_empresa_salvar"><strong>Endereço da empresa</strong></label>
                                        <input type="text" name="endereco_empresa_salvar" id="endereco_empresa_salvar" class="form-control add" placeholder="Digite o endereÃ§o da empresa" />
                                        <span class="" data-name="icon-error"></span>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-danger form-control" data-name="btn-adiciona-fornecedor">Salvar</button>
                                    </div>
                                </form>
                            </div>
                        </div>  
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de edição -->
        <div id="modalEdicao" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i></button>
                        <h4 class="modal-title">Editar fornecedor</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form role="form"  data-name="form-edit">
                                    <input type="hidden" data-name="id_editar" name="id_editar" value="" />
                                    <input type="hidden" name="_method" value="update" />
                                    <div class="form-group  has-feedback">
                                        <label for="nm_fornecedor_editar"><strong>Nome do fornecedor</strong></label>
                                        <input type="text" name="nm_fornecedor_editar" id="nm_fornecedor_editar" class="form-control edit" placeholder="Digite o nome do fornecedor" />
                                        <span class="" data-name="icon-error"></span>
                                    </div>
                                    <div class="form-group  has-feedback">
                                        <label for="nm_empresa_editar"><strong>Nome da empresa</strong></label>
                                        <input type="text" name="nm_empresa_editar" id="nm_empresa_editar" class="form-control edit" placeholder="Digite o nome da empresa" />
                                        <span class="" data-name="icon-error"></span>
                                    </div>
                                    <div class="form-group  has-feedback">
                                        <label for="cd_empresa_editar"><strong>CNPJ da empresa</strong></label>
                                        <input type="text" name="cd_empresa_editar" data-validate='cnpj' id="cd_empresa_editar" class="form-control edit" placeholder="Digite o CNPJ da empresa" />
                                        <span class="" data-name="icon-error"></span>
                                    </div>
                                    <div class="form-group  has-feedback">
                                        <label for="email_empresa_editar"><strong>Email da empresa</strong></label>
                                        <input type="text" name="email_empresa_editar" id="email_empresa_editar" class="form-control edit" placeholder="Digite o email da empresa" />
                                        <span class="" data-name="icon-error"></span>
                                    </div>
                                    <div class="form-group  has-feedback">
                                        <label for="tel_empresa_editar"><strong>Telefone da empresa</strong></label>
                                        <input type="text" name="tel_empresa_editar" data-validate='phone' id="tel_empresa_editar" class="form-control edit" placeholder="Digite o telefone da empresa" />
                                        <span class="" data-name="icon-error"></span>
                                    </div>
                                    <div class="form-group  has-feedback">
                                        <label for="endereco_empresa_editar"><strong>Endereço da empresa</strong></label>
                                        <input type="text" name="endereco_empresa_editar" id="endereco_empresa_editar" class="form-control edit" placeholder="Digite o endereço da empresa" />
                                        <span class="" data-name="icon-error"></span>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-danger form-control" data-name="btn-editar-fornecedor">Salvar</button>
                                    </div>
                                </form>
                            </div>
                        </div>  
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de exclusão -->
        <div class="modal fade" id="modalDelecao" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i></button>
                        <h4 class="modal-title">Você tem certeza que deseja excluir este fornecedor?</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <form role="form">
                                    <div class="form-group text-center" align="left">
                                        <button class="btn btn-success form-control" data-dismiss="modal" type="button" title="Cancelar">Não</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-6">
                                <form role="form">
                                    <input type="hidden" data-name="id_delete" name="id_delete" value="" />
                                    <input type="hidden" name="_method" value="delete" />
                                    <div class="form-group text-center" align="right">
                                        <button class="btn btn-danger form-control" type="submit" title="Excluir">Sim</button>
                                    </div>    
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script src="js/funcao.js" type="text/javascript"></script>
        <script src="js/masked-input.min.js" type="text/javascript"></script>
        <script>
            $(document).ready(function () {
                
                $("[data-validate='phone']").mask("(99) 9999-9999",{placeholder:"(xx) xxxx-xxxx"});
                $("[data-validate='cnpj']").mask("99.999.999/9999-99",{placeholder:"xx.xxx.xxx/xxxx-xx"}); //16.663.566/0001-33
                
                // Adiciona o fornecedor
                $('[data-name="btn-adiciona-fornecedor"]').click(function (button) {
                    button.preventDefault();
                    var status = true;
                    $.map($(".add"), function(item, val){
                        if($(item).val() == "")
                        {
                            $(item).parent().addClass("has-error");
                            $(item).next("span").addClass("glyphicon glyphicon-remove form-control-feedback");
                            status = false;
                        }    
                    });
                    
                    if( validarCNPJ($("#cd_empresa_salvar").val()) == false)
                    {
                        if( !$("#cd_empresa_salvar").hasClass("has-error") )
                        {
                           status = false;
                           $("#cd_empresa_salvar").parent().addClass("has-error");
                           $("#cd_empresa_salvar").next("span").addClass("glyphicon glyphicon-remove form-control-feedback");
                        }
                    }
                    
                    if( status )
                        $('[data-name="form-add"]').submit();
                    else
                        console.log(status);
                });

                // Edita o cliente, com base no seu "id"
                $('[data-name="btn-altera-fornecedor"]').click(function (button) {
                    button.preventDefault();
                    var $this = $(this);
                    $('[data-name="id_editar"]').val($($this).closest("tr").attr("data-id"));

                    $.ajax({
                        url: 'fornecedor',
                        method: "POST",
                        dataType: 'json',
                        data: {
                            '_method': 'select',
                            'id': $('[data-name="id_editar"]').val()
                        }
                    }).done(function (retorno) {
                        console.log(retorno);

                        $("#nm_fornecedor_editar").val(retorno.nome);
                        $("#nm_empresa_editar").val(retorno.nome_social);
                        $("#cd_empresa_editar").val(retorno.cnpj);
                        $("#email_empresa_editar").val(retorno.email);
                        $("#tel_empresa_editar").val(retorno.telefone);
                        $("#endereco_empresa_editar").val(retorno.endereco);
                    });

                });

                $('[data-name="btn-editar-fornecedor"]').click(function (button) {
                    button.preventDefault();
                    var status = true;
                    
                    $.map($(".edit"), function(item, val){
                        if($(item).val() == "")
                        {
                            $(item).parent().addClass("has-error");
                            $(item).next("span").addClass("glyphicon glyphicon-remove form-control-feedback");
                            status = false;
                        }    
                    });
                    
                    if( validarCNPJ($("#cd_empresa_editar").val()) == false)
                    {
                        if( !$("#cd_empresa_salvar").hasClass("has-error") )
                        {
                           status = false;
                           $("#cd_empresa_editar").parent().addClass("has-error");
                           $("#cd_empresa_editar").next("span").addClass("glyphicon glyphicon-remove form-control-feedback");
                        }
                    }
                    
                    if( status )
                        $('[data-name="form-edit"]').submit();
                    else
                        console.log("denied");

                });

                $('[data-name="btn-excui-cliente"]').click(function (button) {
                    var $this = $(this);
                    $('[data-name="id_delete"]').val($($this).closest("tr").attr("data-id"));
                    console.log($('[data-name="id_delete"]').val());
                });
            });
        </script>
    </body>
</html>
