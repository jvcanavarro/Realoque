from flask import Flask

app = Flask(__name__)

@app.route("/municipio/<string:municipio>")
def getBy_municipio(municipio):

    """
    Retorna os imóveis disponíveis em determinado municipio
    :param str municipio:
    :return:
    """


@app.route("/valor/<floar:valor>")
def getBy_valor(valor):

    """
    Retorna os imóveis disponíveis de acordo com o valor
    :param valor:
    :return:
    """
